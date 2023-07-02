<?php

namespace Sas\CustomForm\Service;

class ValidationForm
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(): ?array
    {
        $data = $this->prepareData($this->data);
        if ($this->checkEmptyFields($data)) {
            return null;
        }

        return $data;
    }

    private function checkEmptyFields(array $data): bool
    {

        switch ($data) {
            case $data['firstName'] == "":
            case $data['lastName'] == "":
            case $data['company'] == "":
            case $data['email'] == "":
                return true;
        }

        return false;
    }

    private function prepareData(array $data): array
    {
        $data = reset($data);
        $data = json_decode($data);
        return (array)$data;
    }


}
