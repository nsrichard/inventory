<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use app\models\Product;

class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/html' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $products = Product::find()
            ->with('category')
            ->asArray()
            ->all();

        return [
            'status' => 'success',
            'count' => count($products),
            'data' => $products,
        ];
    }

    public function actionView($id)
    {
        $product = Product::find()
            ->with('category')
            ->asArray()
            ->where(['id' => $id])
            ->one();

        if (!$product) {
            throw new NotFoundHttpException("Product not found.");
        }

        return ['status' => 'success', 'data' => $product];
    }

    public function actionCreate()
    {
        $product = new Product();
        $data = Yii::$app->request->post();

        if ($product->load($data, '') && $product->save()) {
            return ['status' => 'created', 'data' => $product];
        }

        return ['status' => 'error', 'errors' => $product->getErrors()];
    }

    public function actionUpdate($id)
    {
        $product = Product::findOne($id);

        if (!$product) {
            throw new NotFoundHttpException("Product not found.");
        }

        $data = Yii::$app->request->post();

        if ($product->load($data, '') && $product->save()) {
            return ['status' => 'updated', 'data' => $product];
        }

        return ['status' => 'error', 'errors' => $product->getErrors()];
    }

    public function actionDelete($id)
    {
        $product = Product::findOne($id);

        if (!$product) {
            throw new NotFoundHttpException("Product not found.");
        }

        if ($product->delete()) {
            return ['status' => 'deleted'];
        }

        return ['status' => 'error', 'message' => 'Could not delete product.'];
    }
}
