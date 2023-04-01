<?php
require_once "../../bootstrap/bootstrap.php";

class EmployeeDetailPage extends Page
{
    private $employee;
    private $room;

    protected function prepareData(): void
    {
        parent::prepareData();

        //na koho se ptá (příp chyba)
        $employee_id = filter_input(INPUT_GET, 'employee_id', FILTER_VALIDATE_INT);

        if (!$employee_id) {
            throw new BadRequestException();
        }

        //vytáhnu zaměstnance
        $this->employee = Employee::findByID($employee_id);

        //mám ho? (příp chyba)
        if (!$this->employee){
            throw new NotFoundException();
        }

        $this->title = htmlspecialchars( "Zaměstnanec {$this->employee->name} {$this->employee->surname}");

        //vytáhnu místnost
        $this->room = Room::findByID($this->employee->room);
    }

    protected function pageBody(): string
    {
        //ukážu místnost
        return MustacheProvider::get()->render("employee_detail", ['employee' => $this->employee, 'room' => $this->room]);
    }
}

$page = new EmployeeDetailPage();
$page->render();