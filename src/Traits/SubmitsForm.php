<?php


namespace Tanthammar\TallForms\Traits;


trait SubmitsForm
{

    protected function submit()
    {
        $validated_data = data_get($this->validate(), 'form_data', []);
        $fields = $this->getFieldsFlat();

        //filter out custom-, and relationship-fields
        $field_names = [];
        foreach ($fields as $field) {
            if (filled($field) && !$field->is_relation && !$field->is_custom && !$field->ignored) {
                $field_names[] = \Str::of($field->key)->remove('*.')->replaceFirst('form_data.', '')->__toString();
            }
        }

        //remove any unwanted request data
        $model_fields_data = $this->arrayDotOnly($validated_data, $field_names);

        //make sure to create the model before attaching any relations
        $this->success($model_fields_data); //creates or updates the model

        //saveFoo(), for all fields, no matter if it's custom, relation or base field
        foreach ($fields as $field) {
            if (filled($field) && !$field->ignored) {
                $function = $this->parseFunctionNameFrom($field->key, 'save');
                $validated_data = $field->type == 'file' ? $this->{$field->name} : data_get($this, $field->key);
                if (method_exists($this, $function)) $this->$function($validated_data);
            }
        }
    }

    protected function success($model_fields_data)
    {
        // you have to add the methods to your component
        filled($this->model) && $this->model->exists ? $this->onUpdateModel($model_fields_data) : $this->onCreateModel($model_fields_data);
    }

    protected function onUpdateModel($validated_data)
    {
        $this->model->update($validated_data);
    }

    protected function onCreateModel($validated_data)
    {
        $this->model = $this->model::create($validated_data);
    }
}
