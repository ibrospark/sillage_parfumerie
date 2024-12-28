<?php

namespace App\Service;

use Paydunya\Setup;
use Paydunya\Checkout\CheckoutInvoice;
use Exception;

class PayDunyaService
{
  private $masterKey;
  private $privateKey;
  private $publicKey;
  private $token;

  public function __construct(string $masterKey, string $privateKey, string $publicKey, string $token)
  {
    $this->masterKey = $masterKey;
    $this->privateKey = $privateKey;
    $this->publicKey = $publicKey;
    $this->token = $token;

    // Configuration des clés d'API PayDunya
    Setup::setMasterKey($this->masterKey);
    Setup::setPrivateKey($this->privateKey);
    Setup::setPublicKey($this->publicKey);
    Setup::setToken($this->token);
    Setup::setMode('test'); // Changez en 'live' en production
  }

  public function createInvoice(float $amount, string $description, string $userEmail, string $userPhone): string
  {
    $invoice = new CheckoutInvoice();
    $invoice->addItem($description, 1, $amount, $amount);
    $invoice->setTotalAmount($amount);

    $data = [
      'amount' => $amount,
      'currency' => 'XOF',  // Ou la devise que vous utilisez
      'store_name' => 'Nom de votre boutique', // Ajoutez ici le nom de votre boutique
      'email' => $userEmail,
      'phone' => $userPhone,
      'description' => 'Description du paiement',
      // Autres paramètres nécessaires
    ];

    if ($invoice->create()) {
      return $invoice->getInvoiceUrl();
    }

    throw new Exception("Échec de la création de la facture : " . $invoice->response_text);
  }

  public function confirmPayment(string $token): string
  {
    $invoice = new CheckoutInvoice();
    if ($invoice->confirm($token)) {
      return $invoice->status; // Vérifiez si c'est 'completed' pour un paiement réussi
    }

    throw new Exception("Le paiement n'a pas pu être confirmé.");
  }
}
