<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\TicketRequest;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketRequestType extends AbstractType
{
    private const LABEL = 'label';
    private const REQUIRED = 'required';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->andWhere('e.isBookable = 1')
                        ->orderBy('e.datetime', 'ASC');
                },
                self::LABEL => 'Veranstaltung'
            ])
            ->add('amount', null, [self::LABEL => 'Anzahl Eintrittskarten', self::REQUIRED => true])
            ->add('firstname', null, [self::LABEL => 'Vorname', self::REQUIRED => true])
            ->add('lastname', null, [self::LABEL => 'Nachname', self::REQUIRED => true])
//            ->add('street', null, [self::LABEL => 'Straße'])
//            ->add('housenumber', null, [self::LABEL => 'Hausnummer'])
//            ->add('zipcode', null, [self::LABEL => 'Postleitzahl'])
//            ->add('city', null, [self::LABEL => 'Ort', self::REQUIRED => false])
            ->add('emailaddress', EmailType::class, [self::LABEL => 'Email-Adresse', self::REQUIRED => true])
            ->add('phonenumber', null, [self::LABEL => 'Telefonnumer (optional)', self::REQUIRED => false])
            ->add('agreeTerms', CheckboxType::class, ['mapped' => false, self::LABEL => 'Ich stimme den Bedingungen zu.'])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TicketRequest::class,
        ]);
    }
}
