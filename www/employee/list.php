<?php
require_once "../../bootstrap/bootstrap.php";

class EmployeeListPage extends CRUDPage
{
    public string $title = "Seznam zaměstnanců";

    protected function pageBody(): string
    {
        $html = $this->alert();

        //získám data o místnostech
        $employees = Employee::all();
        $rooms = Room::all();

        foreach ($employees as $employee)
        {
            foreach ($rooms as $room)
            {
                if ($employee->room === $room->room_id)
                {
                    $employee->room_name = $room->name . " (" . $room->no . ")";
                    break;
                }
            }
        }

        $isAdmin = $_SESSION["employee"]->admin ?? null;
        $html .= MustacheProvider::get()->render("employee_list", ["employees" => $employees, "isAdmin" => $isAdmin]);
        //vyrenderuju

        return $html;
    }

    private function alert() : string
    {
        $action = filter_input(INPUT_GET, 'action');
        if (!$action)
            return "";

        $success = filter_input(INPUT_GET, 'success', FILTER_VALIDATE_INT);
        $data = [];

        switch ($action)
        {
            case self::ACTION_INSERT:
                if ($success === 1)
                {
                    $data['message'] = 'Zaměstnanec byl založen';
                    $data['alertType'] = 'success';
                }
                else
                {
                    $data['message'] = 'Chyba při založení zaměstnance';
                    $data['alertType'] = 'danger';
                }
                break;

            case self::ACTION_DELETE:
                if ($success === 1)
                {
                    $data['message'] = 'Zaměstnanec byl smazán';
                    $data['alertType'] = 'success';
                }
                else
                {
                    $data['message'] = 'Chyba při mazání zaměstnance';
                    $data['alertType'] = 'danger';
                }
                break;
        }

        return MustacheProvider::get()->render("alert", $data);
    }
}

$page = new EmployeeListPage();
$page->render();