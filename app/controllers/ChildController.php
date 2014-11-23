<?php
class ChildController extends \APIBaseController {
	use ControllerTrait;

	protected $childRepository;

	public function __construct(VacationRepository $childRepository){
		$this->childRepository = $childRepository;
	}

	public function show($child){
		return $child
	}
}
