<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

echo $form->field($formModel, 'logFile')->fileInput();

?>

    <button>Submit</button>

<?php ActiveForm::end() ?>