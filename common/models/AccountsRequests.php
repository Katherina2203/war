<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Description of AccountsRequests
 *
 * @author Yuliya
 */
class AccountsRequests extends \yii\db\ActiveRecord
{
//    public $requests_quantity;
//    
//    public $requests_status;
    
    public static function tableName()
    {
        return '{{%accounts_requests}}';
    }
    
    public function attributes()
    {
        // делаем поле зависимости доступным для поиска
        return array_merge(parent::attributes(), [
            'requests_quantity', 
            'expacted_quantity', 
            'requests_status',
            'accounts_id',
            'unit_price',
            'accounts_quantity',
            'amount',
            'invoice_name',
            'accounts_status',
            'invoice_id',
            'elements_id',
            'project_name',
            'board_id',
            'users_name',
        ]);
    }
    
    public static function getAccountsRequestsDetails($id)
    {
        $sSql = "
        SELECT 
            r.idrequest as requests_id, 
            r.quantity as requests_quantity, 
            FORMAT(ar.quantity, 0) as expacted_quantity, 
            r.status as requests_status,
            ar.accounts_id as accounts_id,
            FORMAT(p.unitPrice, 2) as unit_price,
            a.quantity as accounts_quantity,
            FORMAT(a.amount, 2) as amount,
            CONCAT('№', pi.invoice, ' от ', pi.date_invoice ) as invoice_name,
            a.status as accounts_status, 
            pi.idpaymenti as invoice_id,
            r.estimated_idel as elements_id,
            t.name as project_name, 
            r.idboard as board_id,
            u.surname as users_name

        FROM requests r
        LEFT JOIN accounts_requests ar ON r.idrequest = ar.requests_id
        LEFT JOIN accounts a ON a.idord = ar.accounts_id
        LEFT JOIN prices p ON a.idprice = p.idpr
        LEFT JOIN paymentinvoice pi ON pi.idpaymenti = a.idinvoice
        LEFT JOIN themes t ON t.idtheme = r.idproject
        LEFT JOIN users u ON u.id = r.iduser

        WHERE r.estimated_idel = :estimated_idel 

        ORDER BY r.created_at DESC
        ";
        return AccountsRequests::findBySql($sSql, ['estimated_idel' => $id]);
        
    }
}
