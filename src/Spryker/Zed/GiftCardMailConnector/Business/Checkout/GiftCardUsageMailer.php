<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\GiftCardMailConnector\Business\Checkout;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\GiftCardMailConnector\Communication\Plugin\Mail\GiftCardUsageMailTypePlugin;
use Spryker\Zed\GiftCardMailConnector\Dependency\Facade\GiftCardMailConnectorToMailFacadeInterface;

class GiftCardUsageMailer implements GiftCardUsageMailerInterface
{
    /**
     * @var \Spryker\Zed\GiftCardMailConnector\Dependency\Facade\GiftCardMailConnectorToMailFacadeInterface
     */
    protected $mailFacade;

    /**
     * @param \Spryker\Zed\GiftCardMailConnector\Dependency\Facade\GiftCardMailConnectorToMailFacadeInterface $mailFacade
     */
    public function __construct(GiftCardMailConnectorToMailFacadeInterface $mailFacade)
    {
        $this->mailFacade = $mailFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function sendUsageNotification(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse)
    {
        $quoteTransfer->requireCustomer();

        $mailTransfer = new MailTransfer();
        $mailTransfer = $this->prepareMailTransfer($mailTransfer, $quoteTransfer);

        if ($mailTransfer->getGiftCards()->count() === 0) {
            return;
        }

        $this->mailFacade->handleMail($mailTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    protected function prepareMailTransfer($mailTransfer, $quoteTransfer)
    {
        $mailTransfer->setType(GiftCardUsageMailTypePlugin::MAIL_TYPE);
        $mailTransfer->setCustomer($quoteTransfer->getCustomer());

        foreach ($quoteTransfer->getGiftCards() as $giftCardTransfer) {
            $mailTransfer->addGiftCard($giftCardTransfer);
        }

        return $mailTransfer;
    }
}