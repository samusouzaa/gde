<?php

namespace GDE;

use Doctrine\ORM\Mapping as ORM;

/**
 * PreLita
 *
 * @ORM\Table(name="gde_pre_lista", indexes={@ORM\Index(name="sigla", columns={"sigla"})})
 * @ORM\Entity
 */
class PreLista extends Base {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id_lista", type="integer", options={"unsigned"=true}), nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	protected $id_lista;

	/**
	 * @var PreConjunto
	 *
	 * @ORM\ManyToOne(targetEntity="PreConjunto", inversedBy="lista")
	 * @ORM\JoinColumn(name="id_conjunto", referencedColumnName="id_conjunto")
	 */
	protected $conjunto;

	/**
	 * @var string
	 *
	 * Nao utilizamos uma relation com disciplina aqui pois existem disciplinas equivalentes que nao temos em nosso DB
	 *
	 * @ORM\Column(name="sigla", type="string", nullable=false)
	 */
	protected $sigla;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="parcial", type="boolean", nullable=false)
	 */
	protected $parcial;


}