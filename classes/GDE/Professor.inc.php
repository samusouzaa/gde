<?php

namespace GDE;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professore
 *
 * @ORM\Table(name="gde_professores", uniqueConstraints={@ORM\UniqueConstraint(name="matricula", columns={"matricula"})}, indexes={@ORM\Index(name="nome", columns={"nome"})})
 * @ORM\Entity
 */
class Professor extends Base {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id_professor", type="integer", options={"unsigned"=true}), nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	protected $id_professor;

	/**
	 * @var Oferecimento
	 *
	 * @ORM\OneToMany(targetEntity="Oferecimento", mappedBy="professor")
	 */
	protected $oferecimentos;

	/**
	 * @var Instituto
	 *
	 * @ORM\ManyToOne(targetEntity="Instituto")
	 * @ORM\JoinColumn(name="id_instituto", referencedColumnName="id_instituto")
	 */
	protected $instituto;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="matricula", type="integer", options={"unsigned"=true}), nullable=true)
	 */
	protected $matricula;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nome", type="string", length=255, nullable=false)
	 */
	protected $nome;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="sala", type="string", length=255, nullable=true)
	 */
	protected $sala;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255, nullable=true)
	 */
	protected $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="pagina", type="string", length=255, nullable=true)
	 */
	protected $pagina;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="lattes", type="string", length=255, nullable=true)
	 */
	protected $lattes;

	public function getOferecimentos($periodo = null, $formatado = false, $links = true) {
		if($formatado === false)
			return parent::getOferecimentos();
		else {
			$lista = array();
			foreach(parent::getOferecimentos() as $Oferecimento)
				$lista[] = ($links) ? "<a href=\"".CONFIG_URL."oferecimento/".$Oferecimento->getID()."\" title=\"".$Oferecimento->getDisciplina(true)->getNome(true)."\">".$Oferecimento->getSigla().$Oferecimento->getTurma(true)."</a> (".$Oferecimento->getDisciplina(true)->getCreditos(true).")" : $Oferecimento->getSigla(true).$Oferecimento->getTurma(true)." (".$Oferecimento->getDisciplina(true)->getCreditos(true).")";
			return (count($lista) > 0) ? implode(", ", $lista) : '-';
		}
	}

	/**
	 * @param null $periodo
	 * @return array
	 */
	public function Monta_Horario($periodo = null) {
		$Lista = array();
		foreach($this->getOferecimentos($periodo) as $Oferecimento)
			foreach($Oferecimento->getDimensoes() as $Dimensao)
				$Lista[$Dimensao->getDia()][$Dimensao->getHorario()][] = array($Oferecimento, $Dimensao->getSala(true)->getNome());
		return $Lista;
	}

}