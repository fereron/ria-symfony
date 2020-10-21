<?php
declare(strict_types=1);

namespace Ria\Bundle\PostBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use Ria\Bundle\PostBundle\Repository\StoryRepository;
use Ria\News\Core\Commands\Story\CreateStoryCommand;
use Ria\News\Core\Commands\Story\DeleteStoryCommand;
use Ria\News\Core\Commands\Story\UpdateStoryCommand;
use Ria\News\Core\Forms\Story\StoryForm;
use Ria\News\Core\Forms\Story\StorySearch;
use Ria\News\Core\Models\Story\Story;
use Ria\News\Core\Query\Repositories\StoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class StoryController extends AbstractController
{
//
//    /**
//     * @inheritDoc
//     */
//    public function behaviors(): array
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'allow'       => true,
//                        'permissions' => ['manageStories']
//                    ],
//                ],
//            ],
//        ];
//    }


    private StoryRepository $storyRepository;
    private ParameterBagInterface $parameterBag;

    public function __construct(StoryRepository $storyRepository, ParameterBagInterface $parameterBag)
    {
        $this->storyRepository = $storyRepository;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @Route("posts/stories", methods={"GET"})
     */
    public function actionIndex()
    {
        dd($this->parameterBag->get('locale'));
        $this->storyRepository
            ->createQueryBuilder('s')
            ->select('s')
            ->join('s.translations', 'st', 'WITH', 'st.language = :language')
            ->setParameter(':language', $this->parameterBag->get('locale'));
//        /** @var StoriesRepository $repository */
//        $repository   = $this->entityManager->getRepository(Story::class);
//        $searchModel  = new StorySearch($this->storyRepository);
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $form = StoryForm::create();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->bus->handle(new CreateStoryCommand($form));

            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $form]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $story = $this->findModel(Story::class, $id);
        $form  = StoryForm::create($story);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->bus->handle(new UpdateStoryCommand($form));

            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $form]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->bus->handle(new DeleteStoryCommand($id));

        return $this->redirect(['index']);
    }

    /**
     * @param null $q
     * @param string $language
     * @return \yii\web\Response
     */
    public function actionList(string $language, $q = null)
    {
        /** @var QueryBuilder $query */
        $query = $this->entityManager
            ->getRepository(Story::class)
            ->createQueryBuilder('s');

        $stories = $query
            ->select(['s.id AS id', 'tr.title AS text'])
            ->join('s.translations', 'tr')
            ->where($query->expr()->like('tr.title', ':title'))
//            ->andWhere('s.status = :status')
            ->andWhere('tr.language = :language')
            ->setParameters([
                'title'    => "%$q%",
//                'status'   => true,
                'language' => $language
            ])
            ->getQuery()
            ->execute();

        return $this->asJson(['results' => $stories]);
    }
}