<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\GiftCardMailConnector\Communication\Plugin\Mail;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;
use Spryker\Zed\Mail\Dependency\Plugin\MailTypePluginInterface;

/**
 * @deprecated Use {@link \Spryker\Zed\GiftCardMailConnector\Communication\Plugin\Mail\GiftCardUsageMailTypeBuilderPlugin} instead.
 *
 * @method \Spryker\Zed\GiftCardMailConnector\Business\GiftCardMailConnectorFacadeInterface getFacade()
 * @method \Spryker\Zed\GiftCardMailConnector\Communication\GiftCardMailConnectorCommunicationFactory getFactory()
 * @method \Spryker\Zed\GiftCardMailConnector\GiftCardMailConnectorConfig getConfig()
 */
class GiftCardUsageMailTypePlugin extends AbstractPlugin implements MailTypePluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'gift card usage mail';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getName()
    {
        return static::MAIL_TYPE;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return void
     */
    public function build(MailBuilderInterface $mailBuilder)
    {
        $this
            ->setSubject($mailBuilder)
            ->setHtmlTemplate($mailBuilder)
            ->setTextTemplate($mailBuilder)
            ->setSender($mailBuilder)
            ->setRecipient($mailBuilder);
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setSubject(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setSubject('mail.giftCard.usage.subject');

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setHtmlTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setHtmlTemplate('giftCardMailConnector/mail/gift_card_usage.html.twig');

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setTextTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setTextTemplate('giftCardMailConnector/mail/gift_card_usage.text.twig');

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setRecipient(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->getMailTransfer()->requireCustomer();

        $customerTransfer = $mailBuilder
            ->getMailTransfer()
            ->getCustomer();

        $mailBuilder->addRecipient(
            $customerTransfer->getEmail(),
            $customerTransfer->getFirstName() . ' ' . $customerTransfer->getLastName(),
        );

        return $this;
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function setSender(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->useDefaultSender();

        return $this;
    }
}
