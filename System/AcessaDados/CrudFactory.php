<?php

abstract class CrudFactory extends DoctrineFactory {

    private $entity;

    public function __construct() {
        parent::__construct();
    }

    protected function getEntity() {
        if (class_exists($this->entity)) {
            return $this->entity;
        }
        UtilitariosHelper::getLayoutErrorInicial("Entity inválida!");
    }

    protected function setEntity($entity) {
        $this->entity = $entity;
    }
    
    public function Count(){        
        return count($this->FindAll());
    }

    /**
     * 
     * @param string Entity
     * @return object Entity
     * @example FindAll('Pessoa')
     * @throws PDOException
     */
    public function FindAll() {
        return $this->em->getRepository($this->getEntity())->findAll();
    }

    /**
     * 
     * @param array $criterio
     * @param array $orderBy
     * @param int $limit
     * @param int $offset
     * @return Array object
     * @throws PdoException
     */
    protected function FindBy(Array $criterio = array(),Array $orderBy = array(), $limit = null, $offset = null) {
        return $this->em->getRepository($this->getEntity())
                ->findBy($criterio, $orderBy, $limit, $offset);
    }
    
    
    /**
     * 
     * @param int $id
     * @return Object
     */
    public function Find($id){
        return $this->em->getRepository($this->getEntity())->find($id);
    }

    /**
     * 
     * @param string $entity - Entity do obejto
     * @param array $id - Key da Entity para buscar no banco array('id' => 1)
     * @param object $objetoReference - Objeto referente a entity preenchido
     * @return object Proxy reference
     * @example getReference('Pessoa', array('id' => 1), (object) $pessoa)
     * @throws PDOException
     * 
     */
    public function getReference($primaryKeyId, $objetoReference) {
        $entityRef = $this->em->getReference($this->getEntity(), $primaryKeyId);
        $entityRef = UtilsArrayHelper::getObjectReference($entityRef, UtilsArrayHelper::getArrayByObject($objetoReference));
        return $entityRef;
    }

    /**
     * 
     * @param object reference Entity
     * @example Save($pessoa)
     * @throws PDOException
     */
    protected function Save($objeto) {
        $this->em->persist($objeto);
        $this->em->flush();
    }
    
    public function Remove($id) {

        $obj = $this->Find($id);
        if (count($obj) == 0)
            return true;

        $Entity = $this->getReference($id,$obj);
        if ($Entity) {
            $this->em->remove($Entity);
            $this->em->flush();
        }
    }

}

?>
