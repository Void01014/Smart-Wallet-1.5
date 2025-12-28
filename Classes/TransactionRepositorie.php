<?php
class TransactionRepositorie
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /////////////////////////////////////////

    public function getAllByUser($user_id)
    {
        $sql = "SELECT 'income' AS mode, id, category, amount, date, description
                 FROM income
                 WHERE user_id = ?
                 UNION ALL
                 SELECT 'expense' AS mode, id, category, amount, date, description
                 FROM expense
                 WHERE user_id = ?
                 ORDER BY id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByCategory($user_id, $selectedCategory){
        $sql = "SELECT 'income' AS mode, id, category, amount, date, description
        FROM income
        WHERE user_id = ? AND category = ?
        UNION ALL
        SELECT 'expense' AS mode, id, category, amount, date, description
        FROM expense
        WHERE user_id = ? AND category = ?
        ORDER BY id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $selectedCategory, $user_id, $selectedCategory]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotals($allTransactions)
    {
        $totalIncomes = 0;
        $totalExpenses = 0;

        foreach ($allTransactions as $row) {
            if ($row['mode'] == 'income') {
                $totalIncomes += $row['amount'];
            } else {
                $totalExpenses += $row['amount'];
            }
        }
        return [
            'income'  => $totalIncomes,
            'expense' => $totalExpenses,
            'balance' => $totalIncomes - $totalExpenses
        ];
    }

    public function getMonthStats(){
        $current_year = date("Y");
        $current_month = date("m");

        $sql = "SELECT 'income' AS mode, amount,date
                     FROM income
                     UNION ALL 
                     SELECT 'expense' AS mode, amount, date
                     FROM expense
                     WHERE YEAR(date) = $current_year AND MONTH(date) = $current_month
                     ";

        $inc_amounts = array_fill(0, 31, 0);
        $exp_amounts = array_fill(0, 31, 0);

        $monthResults = $this->pdo->query($sql);

        foreach ($monthResults->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $day = (int)date('j', strtotime($row['date'])) - 1;
            if ($row['mode'] == 'income') {
                $inc_amounts[$day] = (float)$row['amount'];
            } else {
                $exp_amounts[$day] = (float)$row['amount'];
            }
        }

        return [
            'income'  => $inc_amounts,
            'expense' => $exp_amounts
        ];
    }
}
