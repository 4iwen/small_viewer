<?php
require_once "../../bootstrap/bootstrap.php";

class EmployeeInsertPage extends CRUDPage
{
    public string $title = "Upravit zaměstnance";
    protected int $state;
    private Employee $employee;
    private array $errors;

    protected function prepareData(): void
    {
        parent::prepareData();
        $this->state = $this->getState();

        switch ($this->state) {
            case self::STATE_FORM_REQUEST:
                $employeeId = filter_input(INPUT_GET, 'employee_id', FILTER_VALIDATE_INT);
                if (!$employeeId)
                    throw new BadRequestException();

                $this->employee = Employee::findByID($employeeId);
                if (!$this->employee)
                    throw new NotFoundException();

                $this->errors = [];
                break;

            case self::STATE_DATA_SENT:
                //načíst data
                $this->employee = Employee::readPost();
                //zkontrolovat data
                $this->errors = [];
                if ($this->employee->validate($this->errors))
                {
                    //zpracovat
                    $result = $this->employee->update();
                    //přesměrovat
                    $this->redirect(self::ACTION_UPDATE, $result);
                }
                else
                {
                    //na formulář
                    $this->state = self::STATE_FORM_REQUEST;
                }
                break;
        }
    }


    protected function pageBody(): string
    {
        $rooms = Room::all();

        foreach ($rooms as $room)
        {
            if ($room->room_id == $this->employee->room)
                $room->selected = true;
        }

        return MustacheProvider::get()->render("employee_form",
            [
                'employee' => $this->employee,
                'rooms' => $rooms,
                'edit' => true,
                'errors' => $this->errors
            ]);
        //vyrenderuju
    }

    protected function getState() : int
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            return self::STATE_DATA_SENT;

        return self::STATE_FORM_REQUEST;
    }

}

$page = new EmployeeInsertPage();
$page->render();