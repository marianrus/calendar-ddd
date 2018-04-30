<?php

namespace App\Calendar\Application;


use App\Calendar\Application\Event\Events;
use App\Calendar\Application\Event\ExceptionCommandEvent;
use App\Calendar\Application\Event\PostCommandEvent;
use App\Calendar\Application\Event\PreCommandEvent;
use App\Calendar\Application\Exception\ValidationException;
use App\Calendar\Application\Representation\Response;
use App\Calendar\Domain\Exception\DomainException;

class CommandHandler
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var UseCase[]
     */
    private $useCases;

    /**
     * CommandHandler constructor.
     * @param Validator $validator
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(Validator $validator, EventDispatcher $eventDispatcher)
    {
        $this->validator = $validator;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param array $useCases
     */
    public function registerCommands(array $useCases)
    {
        foreach ($useCases as $useCase)
        {
            if ($useCase instanceof UseCase){
                $this->useCases[$useCase->getManagedCommand()] = $useCase;
            }
            throw new \LogicException("use cases expected");
        }
    }

    /**
     * @param $command
     * @return Response
     */
    public function execute($command)
    {
        $this->exceptionIfCommandNotManaged($command);

        try{
            $this->eventDispatcher->notify(Events::PRE_COMMAND, new PreCommandEvent($command));

            $errors = $this->validator->validate($command);

            if ($errors->count() > 0 ) {
                new ValidationException($errors);
            }

            $result =  $this->useCases[get_class($command)]->run($command);

            $this->eventDispatcher->notify(Events::POST_COMMAND, new PostCommandEvent($command));

            return new Response($result);

        }catch (DomainException $e) {
            $this->eventDispatcher->notify(Events::POST_COMMAND, new ExceptionCommandEvent($command));
            return new Response($e->getMessage());
        } catch (ValidationException $e) {
            $this->eventDispatcher->notify(Events::EXCEPTION, new ExceptionCommandEvent($command));
            return new Response($errors);
        }
    }


    /**
     * @param $command
     * @throws \LogicException
     */
    private function exceptionIfCommandNotManaged($command)
    {
        $commandClass = get_class($command);
        if (!array_key_exists($commandClass, $this->useCases)) {
            throw new \LogicException($commandClass . ' is not managed command');
        }
    }
}