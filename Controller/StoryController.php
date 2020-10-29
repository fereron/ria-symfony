<?php
declare(strict_types=1);

namespace Ria\Bundle\PostBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use League\Tactician\CommandBus;
use Ria\Bundle\PostBundle\Command\Story\StoryCreateCommand;
use Ria\Bundle\PostBundle\Form\Story\Type\StoryType;
use Ria\Bundle\PostBundle\Repository\StoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoryController extends AbstractController
{
    // todo manageStories permission

    private StoryRepository $storyRepository;
    private ParameterBagInterface $parameterBag;
    private CommandBus $bus;

    public function __construct(StoryRepository $storyRepository, CommandBus $bus, ParameterBagInterface $parameterBag)
    {
        $this->storyRepository = $storyRepository;
        $this->parameterBag = $parameterBag;
        $this->bus = $bus;
    }

    /**
     * @Route("posts/stories", methods={"GET"}, name="post.stories.index")
     */
    public function index(): Response
    {
        $stories = $this->storyRepository
            ->createQueryBuilder('s')
            ->select('s')
            ->join('s.translations', 'st', 'WITH', 'st.language = :language')
            ->setParameter(':language', $this->parameterBag->get('app.locale'))
            ->getQuery()
            ->getResult();

//        /** @var StoriesRepository $repository */
//        $repository   = $this->entityManager->getRepository(Story::class);
//        $searchModel  = new StorySearch($this->storyRepository);
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@RiaPost/stories/index.html.twig');
    }

    /**
     * @Route("posts/stories/create", methods={"GET", "POST"}, name="post.stories.create")
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $command = new StoryCreateCommand($this->parameterBag->get('app.supported_locales'));

        $form = $this->createForm(StoryType::class, $command);

//        dd($form);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->handle($command);
            return $this->redirectToRoute('posts/stories');
        }

        return $this->render('@RiaPost/stories/create.html.twig', [
            'form' => $form->createView()
        ]);
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