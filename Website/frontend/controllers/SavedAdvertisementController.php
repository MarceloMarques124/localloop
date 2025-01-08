<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\Advertisement;
use yii\web\NotFoundHttpException;
use common\models\SavedAdvertisement;
use frontend\models\SavedAdvertisementSearch;

/**
 * SavedAdvertisementController implements the CRUD actions for SavedAdvertisement model.
 */
class SavedAdvertisementController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all SavedAdvertisement models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $searchModel = new SavedAdvertisementSearch();
        $advertisementsIds = SavedAdvertisement::find()
            ->select('advertisement_id')
            ->where(['user_info_id' => $id])
            ->column();

        $userAdvertisements = Advertisement::find()->where(['id' => $advertisementsIds])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'userAdvertisements' => $userAdvertisements,
        ]);
    }

    /**
     * Displays a single SavedAdvertisement model.
     * @param int $user_info_id User Info ID
     * @param int $advertisement_id Advertisement ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($user_info_id, $advertisement_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_info_id, $advertisement_id),
        ]);
    }

    /**
     * Creates a new SavedAdvertisement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($advertisement_id = null)
    {
        $model = new SavedAdvertisement();

        // Automatically assign the logged-in user's ID and advertisement ID
        $model->user_info_id = \Yii::$app->user->id;
        $model->advertisement_id = $advertisement_id;

        $isFavorite = SavedAdvertisement::findOne(['user_info_id' => $model->user_info_id, 'advertisement_id' => $model->advertisement_id]);
        // Check for existing favorite
        if ($isFavorite) {
            $isFavorite->delete();
            \Yii::$app->session->setFlash('success', 'Removed from favorites!');
        } else {
            // Save the model
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Added to favorites!');
            } else {
                \Yii::$app->session->setFlash('error', 'Could not save favorite. Please try again.');
            }
        }

        return $this->redirect(['site/index']); // Adjust redirection as needed
    }



    /**
     * Updates an existing SavedAdvertisement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $user_info_id User Info ID
     * @param int $advertisement_id Advertisement ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($user_info_id, $advertisement_id)
    {
        $model = $this->findModel($user_info_id, $advertisement_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_info_id' => $model->user_info_id, 'advertisement_id' => $model->advertisement_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SavedAdvertisement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $user_info_id User Info ID
     * @param int $advertisement_id Advertisement ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($user_info_id, $advertisement_id)
    {
        $this->findModel($user_info_id, $advertisement_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SavedAdvertisement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $user_info_id User Info ID
     * @param int $advertisement_id Advertisement ID
     * @return SavedAdvertisement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_info_id, $advertisement_id)
    {
        if (($model = SavedAdvertisement::findOne(['user_info_id' => $user_info_id, 'advertisement_id' => $advertisement_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
