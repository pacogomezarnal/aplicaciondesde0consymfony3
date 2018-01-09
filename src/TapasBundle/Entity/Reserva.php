<?php

namespace TapasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reserva
 *
 * @ORM\Table(name="barpaco_reserva")
 * @ORM\Entity(repositoryClass="TapasBundle\Repository\ReservaRepository")
 */
class Reserva
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="numPersonas", type="integer")
     */
    private $numPersonas;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text")
     */
    private $observaciones;

      /**
      * @ORM\Column(name="aceptada",type="boolean")
      */
     private $aceptada;

    /**
     * Una Reserva tiene un cliente
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="reservas")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Reserva
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set numPersonas
     *
     * @param integer $numPersonas
     *
     * @return Reserva
     */
    public function setNumPersonas($numPersonas)
    {
        $this->numPersonas = $numPersonas;

        return $this;
    }

    /**
     * Get numPersonas
     *
     * @return int
     */
    public function getNumPersonas()
    {
        return $this->numPersonas;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Reserva
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }


    /**
     * Set cliente
     *
     * @param \TapasBundle\Entity\Usuario $cliente
     *
     * @return Reserva
     */
    public function setCliente(\TapasBundle\Entity\Usuario $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \TapasBundle\Entity\Usuario
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set aceptada
     *
     * @param boolean $aceptada
     *
     * @return Reserva
     */
    public function setAceptada($aceptada)
    {
        $this->aceptada = $aceptada;

        return $this;
    }

    /**
     * Get aceptada
     *
     * @return boolean
     */
    public function getAceptada()
    {
        return $this->aceptada;
    }
}
