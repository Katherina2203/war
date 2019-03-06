<?php
namespace common\models;
use Yii;
use \yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "requests".
 *
 * @property integer $idrequest
 * @property integer $type
 * @property string $name
 * @property string $description
 * @property integer $idproduce
 * @property integer $iduser
 * @property integer $idelements
 * @property integer $quantity
 * @property integer $idproject
 * @property integer $idsupplier
 * @property string $required_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $note
 */
class Requests extends \yii\db\ActiveRecord
{
    const REQUEST_NOACTIVE = 0; //
    const REQUEST_ACTIVE = 1; //in progress
    const REQUEST_CANCEL = 2; //cancel
    const REQUEST_DONE = 3; //done
    
    public $processing_count;
    
    public static function tableName()
    {
        return '{{%requests}}';
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
                'updatedByAttribute' => 'edited_by',
            ],
        ];
         
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = \Yii::$app->user->identity->id;
          //  $this->CreatedOn = time();
        } else {
            $this->edited_by = \Yii::$app->user->identity->id;
            //$this->ModifiedOn = time();
        }
    
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->status = self::REQUEST_NOACTIVE;
               // $this->idtype = '1';
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function rules()
    {
        return [
            [['name', 'iduser', 'quantity', 'idproject', 'idtype'], 'required'],
            [['idproduce', 'iduser',  'idproject', 'idboard', 'idsupplier', 'estimated_executor', 'created_by', 'edited_by', 'estimated_category', 'idtype', 'estimated_idel'], 'integer'],
            [['required_date', 'img'], 'safe'],
            [['img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, gif, jpg, jpeg','maxSize' => 1024 * 1024 * 2],
          //  [['img'], 'file', 'maxSize'=>'100000'],
          //  ['status', 'default', 'value' => self::REQUEST_NOACTIVE],
          //  ['status', 'in', 'range' => [self::REQUEST_ACTIVE, self::REQUEST_CANCEL]],
            [['name', 'description', 'status'], 'string', 'max' => 255],
            [['note'], 'string', 'max' => 128],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrequest' => '#заявки',
          //  'status' => 'Статус',
            'status' => Yii::t('app', 'Статус'),
          //  'type' => 'Тип',
         //   'name' => 'Наименование',
            'name' => \yii::t('app', 'Наименование'),
            'description' => \yii::t('app', 'Описание'),
            'idproduce' => \yii::t('app', 'Производитель'),
            'iduser' => \yii::t('app', 'Заказчик'),
            'quantity' => \yii::t('app', 'Количество'),
            'idproject' => \yii::t('app', 'Проект'),
            'idboard' => \yii::t('app', 'Плата'),
            'idsupplier' => \yii::t('app', 'Поставщик'),
            'required_date' => \yii::t('app', 'Требуемая дата'),
            'created_at' => \yii::t('app', 'Создано'),
            'created_by' => \yii::t('app', 'Кем создано'),
            'updated_at' => \yii::t('app', 'Отредактировано'),
            'edited_by' => \yii::t('app', 'Кем отредактировано'),
            'note' => \yii::t('app', 'Примечание'),
            'idtype' => \yii::t('app', 'Тип заявки'),
            'img' => \yii::t('app', 'Файл/Чертеж'),
            'estimated_executor' => \yii::t('app', 'Предполагаемый исполнитель'),
            'estimated_category' => \yii::t('app', 'Предполагаемая категория'),
            'estimated_idel' => \yii::t('app', 'Предполагаемая позиция в базе')
        ];
    }
    
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'iduser']);
    }
    
    public function getThemes()
    {
        return $this->hasOne(Themes::className(), ['idtheme' => 'idproject']);
    }
    public function getBoard()
    {
        return $this->hasOne(Boards::className(), ['idboards' => 'idboard']);
    }
    
    public function getProduce()
    {
        return $this->hasOne(Produce::className(), ['idpr' => 'idproduce']);
    }
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['idsupplier' => 'idsupplier']);
    }
    
    public function getTypeRequest()
    {
        return $this->hasOne(TypeRequest::className(), ['idtype' => 'idtype']);
    }
   
    public function getProcessingrequest()
    {
        return $this->hasOne(Processingrequest::className(), ['idrequest' => 'idrequest']);
    }
    
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['idcategory' => 'estimated_category']);
    }
    
    public function getOrders() 
    {
        return $this->hasMany(Purchaseorder::className(), ['idpo' => 'idorder'])
                ->viaTable('requests_orders', ['idorder' => 'idpo']);
    }
    
    public function getElements() 
    {
        return $this->hasMany(Elements::className(), ['idelements' => 'idelement'])->viaTable('purchaseorder', ['idrequest' => 'idrequest']);
    }
    
    public function getPurchaseorder()
    {
        return $this->hasOne(Purchaseorder::className(), ['idrequest' => 'idrequest']);
    }
    
    public function getAccounts() 
    {
        return $this->hasMany(Accounts::className(), ['idelem' => 'idelement'])->viaTable('purchaseorder', ['idrequest' => 'idrequest']);
    }
    
    public function getRequestStatusHistory()
    {
        return $this->hasOne(RequestStatusHistory::className(), ['idrequest' => 'idrequest']);
    }
    
    public function getPaymentinvoice() 
    {
        return $this->hasMany(Paymentinvoice::className(), ['idpaymenti' => 'idinvoice']);
    }
    
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }
 
    public static function getStatusesArray()
    {
        return [
            self::REQUEST_NOACTIVE => 'Не размещено',
            self::REQUEST_ACTIVE => 'Активно',
            self::REQUEST_CANCEL => 'Отменено',
            self::REQUEST_DONE => 'Выполнено',
        ];
    }
    
    private $_requestsArray;
    public function getRequestsArray()
    {
        if ($this->_requestsArray === null) {
            $this->_requestsArray = $this->getProcessingrequest()->select('idrequest')->column();
        }
        return $this->_requestsArray;
    }
    
    public function showIds(){
        $currentRequestIds = $this->getProcessingrequest()->select('idrequest')->column();
        $newRequestIds = $this->getRequestsArray();
        
        foreach (array_filter(array_diff($newRequestIds, $currentRequestIds)) as $requestId) {
            /** @var Tag $tag */
            if ($request = Requests::findOne($requestId)) {
                $this->link('tags', $request);
            }
        }
        foreach (array_filter(array_diff($currentTagIds, $newTagIds)) as $tagId) {
            /** @var Tag $tag */
            if ($request = Requests::findOne($requestId)) {
                $this->unlink('tags', $request, true);
            }
        }
    }
    
    public function getProject(){
        //return $this->themes->select('name')->where(['status' => 'active'])->column();
       return  $this->themes->name;
    } 
    public function getCustomer(){
        //return $this->themes->select('name')->where(['status' => 'active'])->column();
       return  $this->users->getUserName();
    } 
    
    
}