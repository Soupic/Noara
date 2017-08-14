<?php
/**
 * Created by PhpStorm.
 * User: picsou
 * Date: 14/08/17
 * Time: 15:19
 */

namespace PageBundle\Exception;


class AbstractNoaraException extends \Exception
{
    /**
     * @var string
     */
    private $identifiantUnique;

    /**
     * AbstractNoaraException constructor.
     * @param string          $message
     * @param string          $identifiantUnique
     * @param \Exception|null $previous
     */
    public function __construct(
        $message,
        $identifiantUnique,
        \Exception $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->identifiantUnique = $identifiantUnique;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // 0) création du message d'erreur
        $message = "";

        // 1) ajout du code d'erreur
        $message .= "[{$this->getIdentifiantUnique()}]";

        // 2) ajout du message de l'erreur
        $message .= " {$this->getMessage()}";

        return $message;
    }

    /**
     * @return string
     */
    public function getIdentifiantUnique()
    {
        return $this->identifiantUnique;
    }
}