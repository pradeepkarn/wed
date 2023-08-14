<?php

use phpseclib3\Crypt\RSA;

// Shared symmetric key for message encryption
$sharedSymmetricKey = "supersecretkey";

// Sender's private key (not recommended to hardcode private keys)
$senderPrivateKey = "sender_private_key";

// Receiver's public key (should be retrieved from a secure storage)
$receiverPublicKey = "receiver_public_key";

class Enc_dyc
{
    function encryptMessage($message, $key)
    {
        return base64_encode(openssl_encrypt($message, 'aes-256-cbc', $key, OPENSSL_RAW_DATA));
    }

    function decryptMessage($encryptedMessage, $key)
    {
        return openssl_decrypt(base64_decode($encryptedMessage), 'aes-256-cbc', $key, OPENSSL_RAW_DATA);
    }

    function set_enc($receiverPublicKey,$sharedSymmetricKey)
    {
        $message = "Hello, this is a secret message.";

        // Encrypt message using shared symmetric key
        $encryptedMessage = $this->encryptMessage($message, $sharedSymmetricKey);

        // Encrypt shared symmetric key using receiver's public key
        $rsa = new RSA();
        $rsa->loadKey($receiverPublicKey);
        $encryptedSharedKey = base64_encode($rsa->encrypt($sharedSymmetricKey));

        // Simulate sending the encrypted message and encrypted key to the receiver
        $receiverEncryptedMessage = $encryptedMessage;
        $receiverEncryptedSharedKey = $encryptedSharedKey;

        // Store the encrypted message and encrypted shared key in the database
        // ...

        echo "Message sent and stored in the database.\n";
    }
}
