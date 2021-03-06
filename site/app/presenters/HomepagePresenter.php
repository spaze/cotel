<?php
namespace App\Presenters;

/**
 * Homepage presenter.
 *
 * @author     Michal Špaček
 * @package    michalspacek.cz
 */
class HomepagePresenter extends \Nette\Application\UI\Presenter
{

	/** @var \Nette\Database\Context */
	protected $database;

	/** @var array */
	private $tags = array();

	public function __construct(\Nette\Database\Context $context)
	{
		$this->database = $context;
	}


	public function actionDefault($param)
	{
		// Yes, I hate this code, too.
		// Yes, it was the fastest way to build a prototype.
		// Yes, it would just kill the database server later on.
		// No, do not use anywhere.
		// Yes, you have just been warned.
		$this->tags = array_filter(preg_split('/\s+/', $param));
		if (empty($this->tags)) {
			$query = 'SELECT * FROM urls';
		} else {
			$query = 'SELECT * FROM urls WHERE id IN (
				SELECT s1.url_id FROM
					(SELECT ut.url_id FROM url_tags ut JOIN tags t ON ut.tag_id = t.id WHERE t.tag IN (?)) s1' . "\n";
			for ($i = 2; $i <= count($this->tags); $i++) {
				$query .= "JOIN (SELECT ut.url_id FROM url_tags ut JOIN tags t ON ut.tag_id = t.id WHERE t.tag IN (?)) s{$i} ON s1.url_id = s{$i}.url_id\n";
			}
			$query .= ')';
		}
		$result = call_user_func_array([$this->database, 'fetchAll'], array_merge([$query], $this->tags));
		$urls = array();
		foreach ($result as $url) {
			$urls[$url->id] = $url;
			$urls[$url->id]->tags = array();
		}
		if (!empty($urls)) {
			$urlTags = $this->database->fetchAll('
				SELECT
					ut.url_id AS urlId,
					t.tag,
					tc.category AS category
				FROM
					tags t
					JOIN url_tags ut ON t.id = ut.tag_id
					LEFT JOIN tag_categories tc ON t.category_id = tc.id
				WHERE
					ut.url_id IN (?)
				ORDER BY
					t.category_id,
					t.tag
			', array_keys($urls));
			foreach ($urlTags as $tag) {
				$urls[$tag->urlId]->tags[] = $tag;
			}
		}
		$allTags = array_values($this->database->fetchPairs('SELECT id, tag FROM tags ORDER BY tag'));

		$this->template->tags = $this->tags;
		$this->template->urls = $urls;
		$this->template->allTags = $allTags;
	}


	protected function createComponentSearch($formName)
	{
		$form = new \Cotel\Form\SearchForm($this, $formName);
		$form->setTags($this->tags);
		$form->onSuccess[] = $this->submittedSearch;
	}


	protected function createComponentMedia($formName)
	{
		$form = new \Cotel\Form\MediaForm($this, $formName);
		$form->onSuccess[] = $this->submittedMedia;
	}


	public function submittedSearch(\Cotel\Form\SearchForm $form)
	{
		$values = $form->getValues();
		$this->redirect('default', $values->search);
	}


	public function submittedMedia(\Cotel\Form\MediaForm $form)
	{
		$values = $form->getValues();
		$tags = array_filter(preg_split('/\s+/', $values->tags));
		$this->database->beginTransaction();
		$this->database->query('INSERT INTO urls', array(
			'url'       => $values->url,
			'title'     => $values->title,
			'published' => new \DateTime($values->published),
			'added'     => new \DateTime('now'),
		));
		$urlId = $this->database->getInsertId();
		$tagIds = array();
		foreach ($tags as $tag) {
			$this->database->query('INSERT INTO tags ? ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)', array('tag' => $tag));
			$this->database->query('INSERT INTO url_tags', ['url_id' => $urlId, 'tag_id' => $this->database->getInsertId()]);
		}
		$this->database->commit();
		$this->redirect('this');
	}


}