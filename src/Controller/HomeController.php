<?php

namespace App\Controller;

use App\Entity\Entry;
use App\Form\CredentialsFormType;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, HttpClientInterface $httpClient): Response
    {
        $form = $this->createForm(CredentialsFormType::class)->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()) {
            $jar = new CookieJar();
            $client = new Client(['base_uri'=>'https://cas.univ-lehavre.fr','cookies'=>$jar]);
            $resp = $client->get('/cas/login');
            $crawler = new Crawler($resp->getBody()->getContents());
            $token = $crawler->filter('input[name="lt"]')->attr('value');
            $execution = $crawler->filter('input[name="execution"]')->attr('value');
            $resp = $client->request('POST','/cas//login',[
                'allow_redirects' => false,
                'body' => 'username='.$form->get('username')->getData().'&password='.$form->get('password')->getData().'&lt='.$token.'&execution='.$execution.'&_eventId=submit',
                'headers' => ['Content-type' => 'application/x-www-form-urlencoded'],
                'cookies' => $jar
            ]);
            if(count($jar->toArray()) < 3 )
            {
                $this->addFlash('danger', 'Could not retrieve data. Please make sure your username and password are rights');
                return $this->redirectToRoute('home');
            }
            $resp = $client->request('GET', 'https://www-apps.univ-lehavre.fr/hyperespace/', [
                'cookies' => $jar,
                'allow_redirects' => [
                    'max' => 10
                ]
            ]);
            $crawler = new Crawler($resp->getBody()->getContents());
            $GLOBALS['notes'] = [];
            $GLOBALS['curDomain'] = null;
            $crawler->filter('table tbody tr')->each(function (Crawler $node, $i) {
                $node->filter('th,td')->each(function (Crawler $node, $i) {
                    if(preg_match('/^D[0-9]$/', $node->text()) == 1) {
                        if(!isset($GLOBALS['notes'][$node->text()])) {
                            $GLOBALS['notes'][$node->text()] = [
                                'total' => 0,
                                'validated' => 0,
                                'not-validated' => 0
                            ];
                        }
                        $GLOBALS['curDomain'] = $node->text();
                    }
                    if($GLOBALS['curDomain'] != null and $node->text() == '✓') {
                        $GLOBALS['notes'][$GLOBALS['curDomain']]['validated']++;
                        $GLOBALS['notes'][$GLOBALS['curDomain']]['total']++;
                    }
                    if($GLOBALS['curDomain'] != null and $node->text() == '✗') {
                        $GLOBALS['notes'][$GLOBALS['curDomain']]['not-validated']++;
                        $GLOBALS['notes'][$GLOBALS['curDomain']]['total']++;
                    }
                });
            });
            ksort($GLOBALS['notes']);
            return $this->renderForm('home/index.html.twig',[
                'form' => $form,
                'notes' => $GLOBALS['notes']
            ]);
        }
        return $this->renderForm('home/index.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/classement', name: 'app_classement')]
    public function classement(PaginatorInterface $paginator, EntityManagerInterface $em) {
        $avg = [];
        $avg['D1'] = $em->getRepository(Entry::class)->query('c',[],[],null,'AVG(c.D1) as avg_d1')->getSingleScalarResult();
        $avg['D2'] = $em->getRepository(Entry::class)->query('c',[],[],null,'AVG(c.D2) as avg_d2')->getSingleScalarResult();
        $avg['D3'] = $em->getRepository(Entry::class)->query('c',[],[],null,'AVG(c.D3) as avg_d3')->getSingleScalarResult();
        $avg['D4'] = $em->getRepository(Entry::class)->query('c',[],[],null,'AVG(c.D4) as avg_d4')->getSingleScalarResult();
        $avg['D5'] = $em->getRepository(Entry::class)->query('c',[],[],null,'AVG(c.D5) as avg_d5')->getSingleScalarResult();
        $avg['D6'] = $em->getRepository(Entry::class)->query('c',[],[],null,'AVG(c.D6) as avg_d6')->getSingleScalarResult();
        $avg['total'] = $em->getRepository(Entry::class)->query('c',[],[],null,'AVG(c.total) as avg_total')->getSingleScalarResult();
        $avg['acquieredDomains'] = $em->getRepository(Entry::class)->query('c',[],[],null,'AVG(c.acquieredDomains) as avg_acquieredDomains')->getSingleScalarResult();
        $classement = $paginator->paginate(
            $em->getRepository(Entry::class)->query('c'),
            1,
            50,
            ['defaultSortDirection'=>'DESC','defaultSortFieldName'=>'c.total']
        );

        return $this->renderForm('home/classement.html.twig', [
            'classement' => $classement,
            'avg' => $avg
        ]);
    }
}
