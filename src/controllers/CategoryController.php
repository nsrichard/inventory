<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use app\models\Category;

class CategoryController extends Controller
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
        $categories = Category::find()
            ->asArray()
            ->all();

        return [
            'status' => 'success',
            'count' => count($categories),
            'data' => $categories,
        ];
    }

    public function actionView($id)
    {
        $category = Category::find()
            ->asArray()
            ->where(['id' => $id])
            ->one();

        if (!$category) {
            throw new NotFoundHttpException("Category not found.");
        }

        return ['status' => 'success', 'data' => $category];
    }

    public function actionCreate()
    {
        $category = new Category();
        $data = Yii::$app->request->post();

        if ($category->load($data, '') && $category->save()) {
            return ['status' => 'created', 'data' => $category];
        }

        return ['status' => 'error', 'errors' => $category->getErrors()];
    }

    public function actionUpdate($id)
    {
        $category = Category::findOne($id);

        if (!$category) {
            throw new NotFoundHttpException("Category not found.");
        }

        $data = Yii::$app->request->post();

        if ($category->load($data, '') && $category->save()) {
            return ['status' => 'updated', 'data' => $category];
        }

        return ['status' => 'error', 'errors' => $category->getErrors()];
    }

    public function actionDelete($id)
    {
        $category = Category::findOne($id);

        if (!$category) {
            throw new NotFoundHttpException("Category not found.");
        }

        if ($category->delete()) {
            return ['status' => 'deleted'];
        }

        return ['status' => 'error', 'message' => 'Could not delete category.'];
    }
}
