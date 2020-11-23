<?php

namespace app\controllers;

use Yii;
use kartik\mpdf\Pdf;
use yii\web\Controller;


class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function verbs() {
        return array_merge(
            parent::verbs(),
            [
                'html2pdf' => ['POST']
            ]
        );
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPdf() {
        set_time_limit(0);
        
        $content = Yii::$app->getRequest()->getRawBody();
        $inlineCss = Yii::$app->getRequest()->getHeaders()->get('inline-css', '');

        if (!empty($inlineCss)) {
            $inlineCss = base64_decode($inlineCss);
        }

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // output file
            // 'filename' => 'file.pdf',
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => $inlineCss,
            // set mPDF properties on the fly
            'options' => ['title' => ""],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>[''],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        $pdf->render();
    }
}
