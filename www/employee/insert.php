<?php
require_once "../../bootstrap/bootstrap.php";

class EmployeeInsertPage extends CRUDPage
{
    public string $title = "Založit nového zaměstnance";
    protected int $state;
    private Employee $employee;
    private array $errors;

    protected function prepareData(): void
    {
        parent::prepareData();
        $this->state = $this->getState();

        switch ($this->state) {
            case self::STATE_FORM_REQUEST:
                $this->employee = new Employee();
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
                    $result = $this->employee->insert();
                    //přesměrovat
                    $this->redirect(self::ACTION_INSERT, $result);
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

        return MustacheProvider::get()->render("employee_form",
            [
                'employee' => $this->employee,
                'rooms' => $rooms,
                'edit' => false,
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