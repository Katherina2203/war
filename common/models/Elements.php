<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Html;
/**
 * This is the model class for table "elements".
 *
 * @property integer $idelements
 * @property string $box
 * @property string $name
 * @property string $nominal
 * @property integer $quantity
 * @property integer $idproduce
 * @property integer $idcategory
 * @property string $image
 * @property string $active
 */
class Elements extends \yii\db\ActiveRecord
{
   // public $string;
    //public $filename;
   // public $image;
    const IMAGE_PLACEHOLDER = 'frontend/images/no-image.png';
    
    const ELEMENT_ACTIVE = 1;
    const ELEMENT_NOACTIVE = 2;

   
    public static function tableName()
    {
        return '{{%elements}}';
    }

    public function behaviors() {
        return [
            'timestamp' => [
               'class' => TimestampBehavior::className(),
               'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
         
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = \yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->updated_by = \yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }
    
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
               
            }
            return true;
        } else {
            return false;
        }
    }

  //  const INSERT = 'insert';
  //  const UPDATE = 'update';

  /*  public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::INSERT] = ['image'];
        $scenarios[self::UPDATE] = ['image'];
        return $scenarios;
    }*/
    
    public function rules()
    {
        return [
            [['box', 'name', 'nominal', 'idcategory', 'idproduce'], 'required'],
            [['quantity', 'idproduce', 'idcategory', 'created_by' , 'updated_by'], 'integer'],
            ['box', 'required', 'message' => 'Please choose a category'],
          //  [['name', 'nominal'], 'string', 'max' => 20],
            ['idcategory', 'required', 'message' => 'Please choose a category'],
            ['idproduce', 'required', 'message' => 'Please choose a produce'],
            ['active', 'default', 'value' => self::ELEMENT_ACTIVE],
         //   [['box'], 'string', 'max' => 20],
            [['name', 'nominal'], 'string', 'max' => 82],
            [['image', 'quantity'], 'safe' ], //'on' => ['upload', 'update']
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, gif, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
           // [['quantity'], 'numerical'], //, 'min'=>0, 'message'=>'{attribute} must be greater than zero.'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idelements' => Yii::t('app', 'Id'),
            'box' => Yii::t('app', 'Box'),
            'name' => Yii::t('app', 'Name'),
            'nominal' => Yii::t('app', 'Nominal'),
            'quantity' => Yii::t('app', 'Quantity'),
            'idproduce' => Yii::t('app', 'Manufacturer'),
            'idcategory' => Yii::t('app', 'Category'),
            'image' => Yii::t('app', 'Img'),
            'created_at' => Yii::t('app', 'Created at'),
            'created_by' => Yii::t('app', 'Кем создано'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'updated_by' => Yii::t('app', 'Кем редактировано'),
            'active' => Yii::t('app', 'Active'),
        ];
    }
    
   
    
  /*  public function beforeSave($insert) {
        if($this->isNewRecord){
            //generate & upload
            $this->string = substr(uniqid('img'), 0, 12); //imgRandomString Длиной 12 символов
            $this->image = UploadedFile::getInstance($this, 'image');
         //   $this->filename = 'images/' .$this->string.  '.' . $this->image->extension;
            $this->image->saveAs($this->filename);
            //save
            $this->image = '/'. $this->filename; 
        }else{
            $this->image = \yii\web\UploadedFile::getInstance($this, 'images');
            
            if($this->image){
                $this->image->saveAs(substr($this->image, 1));
            }
        }
        
        return parent::beforeSave($insert);
    }*/
    
    public function getId()
    {
        return $this->idelements;
    }
       
    public function getProduce(){
        return $this->hasOne(Produce::className(), ['idpr' => 'idproduce']);
    }
    
    public function getCategory() {
        return $this->hasOne(Category::className(), ['idcategory' =>'idcategory']);
    }
    
    public function getOrder() {
        return $this->hasOne(Orders::className(), ['idelement' =>'idelements']);
    }
    
    public function getPurchaseorder() {
        return $this->hasMany(Purchaseorder::className(), ['idelement' =>'idelements']);
    }
    
    public function getRequests(){
         return $this->hasMany(Requests::className(), ['idrequest' => 'idrequest'])
            ->viaTable('purchaseorder', ['idelement' => 'idelements']);
    }
    
    public function getReserve() {
        return $this->hasOne(Reserve::className(), ['idelement' =>'idelements']);
    }
    
    public function getElements() {
        return $this->hasOne(Shortage::className(), ['idelement' =>'idelements']);
    }
    
    public function getAccounts() {
        return $this->hasMany(Accounts::className(), ['idelem' =>'idelement'])->viaTable('purchaseorder', ['idelement' => 'idelements']);
    }
    public function getInvoice() {
        return $this->hasOne(Accounts::className(), ['idelem' =>'idelements']);
    }
    
    public function getManufacturerName(){
       /*  $produce = Produce::find()
                ->select(['p.idpr', 'p.manufacture'])
                ->join('JOIN', 'produce p', 'produce.idpr = p.idpr')
               // ->where(['themes.status' => 'active'])
                //->distinct(TRUE)
                ->all();
        
        return \yii\helpers\ArrayHelper::map($produce, 'idpr', 'manufacture');*/
        return $this->idproduce;
    }
    
    public function getDisplayImage() {
    if (empty($model->image)) {
        // if you do not want a placeholder
        $image = null;
 
        // else if you want to display a placeholder
        $image = Html::img(self::IMAGE_PLACEHOLDER, [
            'alt'=>Yii::t('app', 'No image'),
         //   'title'=>Yii::t('app', 'Upload your avatar by selecting browse below'),
            'class'=>'file-preview-image'
            // add a CSS class to make your image styling consistent
        ]);
    }
    else {
        $image = Html::img(Yii::$app->urlManager->baseUrl . '/' . $model->image, [
            'alt'=>Yii::t('app', 'Image for ') . $model->name. ', ' . $model->nominal,
          //  'title'=>Yii::t('app', 'Click remove button below to remove this image'),
            'class'=>'file-preview-image'
            // add a CSS class to make your image styling consistent
        ]);
    }
 
    // enclose in a container if you wish with appropriate styles
    return ($image == null) ? null : 
        Html::tag('div', $image, ['class' => 'file-preview-frame']); 
    }
    
    public function getFulname(){
        return $this->name . ', ' . $this->nominal;
    }
    
}
