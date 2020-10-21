<?php
declare(strict_types=1);

namespace Ria\Bundle\PostBundle\Form;

class StorySearch
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var bool
     */
    public $status;
    /**
     * @var bool
     */
    public $show_on_site;
    /**
     * @var StoriesRepository
     */
    private $repository;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'show_on_site', 'id'], 'integer'],
            ['title', 'string'],
        ];
    }

    /**
     * StoriesSearchForm constructor.
     * @param StoriesRepository $repository
     * @param array $config
     */
    public function __construct(StoriesRepository $repository, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }

    /**
     * @param $params
     * @return DataProviderInterface
     */
    public function search($params): DataProviderInterface
    {
        $query = $this->repository->createQueryBuilder('s');

        $dataProvider = new DoctrineDataProvider([
            'query'      => $query,
            'modelClass' => $this->repository->getClassName(),
            'sort'       => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize'      => 12,
                'pageSizeParam' => false
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query
            ->join('s.translations', 'st', 'WITH', 'st.language = :lang')
            ->setParameter(':lang', \Yii::$app->language);

        if ($this->id) {
            $query->andWhere($query->expr()->eq('s.id', $this->id));
        }

        if ($this->status) {
            $query->andWhere($query->expr()->eq('s.status', $this->status));
        }

        if ($this->show_on_site) {
            $query->andWhere($query->expr()->eq('s.show_on_site', $this->show_on_site));
        }

        return $dataProvider;
    }
}