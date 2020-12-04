<?php
namespace App\Controller;

use App\Entity\Event;
use App\Entity\TicketRequest;
use App\Form\TicketRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ticket_request")
 */
class TicketRequestController extends AbstractController
{
    /** @var MailerInterface */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        if (!$this->getDoctrine()->getRepository(Event::class)->hasBookableEvent()) {
            return $this->render('main/error.html.twig', [
                'error_title' => 'Es gibt zurzeit keine Veranstaltungen, für die Karten gebucht werden können.',
                'error_message' => 'Entweder bist Du zu früh und der Vorverkauf hat noch nicht begonnen, oder Du bist zu spät und wir sind bereits ausverkauft.',
                'target_page' => 'Zu den Theaterstücken',
                'target_path' => $this->generateUrl('app_production_list')
            ]);
        }

        $form = $this->createForm(TicketRequestType::class, TicketRequest::createDefault());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var TicketRequest $ticketRequest */
            $ticketRequest = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticketRequest);
            $entityManager->flush();
            $entityManager->refresh($ticketRequest);

            $this->sendConfirmationEmail($ticketRequest);
            $this->sendRequestEmail($ticketRequest);

            return $this->redirectToRoute(
                'app_production_list',
                ['id' => $ticketRequest->getEvent()->getProduction()->getId()]
            );
        }

        return $this->render('tickets/request.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function sendConfirmationEmail(TicketRequest $request)
    {
        $email = (new Email())
            ->from(Address::fromString('Kartenanfrage Theaterwerkstatt <kartenanfrage@theaterwerkstatt-holm.de>'))
            ->to($request->getEmailaddress())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo('kartenanfrage@theaterwerkstatt-holm.de')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Deine Kartenanfrage bei der Theaterwerkstatt Holm')
            ->text('Wir haben Deine Kartenanfrage erhalten!')
            ->html('<p>Wir haben Deine Kartenanfrage erhalten!</p>');

        $email->getHeaders()
            ->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');

        $this->mailer->send($email);
    }

    private function sendRequestEmail(TicketRequest $request)
    {
        $email = (new Email())
            ->from($request->getEmailaddress())
            ->to('kartenanfrage@theaterwerkstatt-holm.de')
            ->bcc('florian.isachsen@gmx.de')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Kartenanfrage '.$request->getId())
            ->text((string)$request);

        $this->mailer->send($email);
    }
}
