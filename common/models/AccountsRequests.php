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
            'received_quantity', 
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
            'delivery',
            'date_receive',
            'elements_name',
            'elements_nominal',
            

        ]);
    }
    
    public static function getAccountsRequestsDetails($id)
    {
        $sSql = "
        SELECT 
            ar.id as id,
            r.idrequest as requests_id, 
            r.quantity as requests_quantity, 
            FORMAT(ar.quantity, 0) as received_quantity, 
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
    
    public static function getAccountsForRequest($invoices_id, $requests_id, $elements_id = null)
    {
        $sSql = "
            SELECT 
                ar.requests_id as requests_id,
                ar.accounts_id as accounts_id,
                FORMAT(p.unitPrice, 2) as unit_price,
                a.quantity as accounts_quantity,
                FORMAT(a.amount, 2) as amount,
                a.status as accounts_status, 
                a.idelem as elements_id, 
                a.delivery,
                a.date_receive,
                e.name as elements_name

            FROM accounts_requests ar, accounts a, prices p, elements e  
            WHERE ar.accounts_id = a.idord 
                AND a.idinvoice = :invoices_id 
                AND a.idprice = p.idpr 
                AND e.idelements = a.idelem
                AND a.status in ('2', '5')
        ";
        
        $aParam = [
            'requests_id' => $requests_id, 
            'invoices_id' => $invoices_id,
        ];
        
        if (is_null($elements_id)) {
            $sSql .= " AND ar.requests_id = :requests_id ";
        } else {
            $sSql .= "
                AND (
                    ar.requests_id = :requests_id 
                    OR (
                        ar.requests_id != :requests_id 
                        AND e.idelements = :elements_id
                        AND ar.accounts_id NOT IN (
                            SELECT accounts_id 
                            FROM accounts_requests  
                            WHERE requests_id = :requests_id
                        ) 
                    )
                )";
            $aParam['elements_id'] = $elements_id;
        }
        return AccountsRequests::findBySql($sSql, $aParam);
    }


}
