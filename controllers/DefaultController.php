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
                'html2pdf'  => ['POST'],
                'ping'      => ['get']
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

    public function actionPing() {
        return date('Y-m-d H:i:s', strtotime('now'));
    }

    /**
     * @endpoint /html2pdf
     * @method POST
     *
     */
    public function actionPdf() {
        set_time_limit(0);
        
        $content = Yii::$app->getRequest()->getRawBody();
        $inlineCss = Yii::$app->getRequest()->getHeaders()->get('inline-css', '');
        $portrait = Yii::$app->getRequest()->getHeaders()->get('portrait', 'true');

        if (!empty($inlineCss)) {
            $inlineCss = base64_decode($inlineCss);
        }

        // Override fonts settings and include new fonts
        $mpdfConfigPath = __DIR__ . '/../config/mpdf/';
        define('_MPDF_PATH', $mpdfConfigPath);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => $portrait === 'false' ? Pdf::ORIENT_LANDSCAPE : Pdf::ORIENT_PORTRAIT,
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
                'SetFooter'=>['{PAGENO} / {nb}'],
            ]
        ]);

        $pdf->getApi()->text_input_as_HTML = true;
        $pdf->getApi()->autoScriptToLang = true;

        $pdf->render();
    }
}
