<?php

namespace Core\DB\QueryBuilder;

use Exception;

class QueryBuilder
{
    /**
     * @param string $table takes tablename as string
     * @param array $fields accepts an array of fields in $table
     * @return string $sql returns query as string
     * 
     */
    public static function insert($table, $fields = [])
    {
        $fieldString = '';
        $valueString = '';
        $values = [];
        foreach ($fields as $field => $value) {
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }
        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');
        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
        return $sql;
    }

    /**
     * @param string $table takes tablename as string
     * @param array $params accepts an associative array of fields in $table where conditions=>what is selected, order=>what to order by and limit=>put constraints
     * @return string $sql returns query as string
     * 
     */
    protected static function read($table, $params = [])
    {
        $conditionString = '';
        $order = '';
        $limit = '';
        if (isset($params['conditions']) && is_array($params['conditions'])) {
            foreach ($params['conditions'] as $condition) {
                $conditionString .= ' ' . $condition . ' AND';
            }
            $conditionString = trim($conditionString);
            $conditionString = rtrim($conditionString, ' AND');
            $conditionString = " WHERE " . $conditionString;
        } elseif (isset($params['conditions']) && !is_array($params['conditions'])) {
            $conditionString = $params['conditions'];
        }
        // Order
        if (array_key_exists('order', $params)) {
            $order = ' ORDER BY ' . $params['order'];
        }
        // Limit
        if (array_key_exists('limit', $params)) {
            $limit = ' LIMIT ' . $params['limit'];
        }
        $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
        return $sql;
    }

    /**
     * @param string $table takes tablename as string
     * @param int $prKey primary key of the record
     * @param array $fields accepts an array of fields in $table
     * @return string $sql returns query as string
     * 
     */
    public static function update($table, $prKey, $fields = [])
    {
        if (!empty($table) && !empty($prKey) && !empty($fields)) {
            $fieldString = '';
            $values = [];
            foreach ($fields as $field => $value) {
                $fieldString .= ' ' . $field . '=?,';
                $values[] = $value;
            }
            $fieldString = trim($fieldString);
            $fieldString = rtrim($fieldString, ',');
            $sql = "UPDATE {$table} SET {$fieldString} WHERE id={$prKey}";
            return $sql;
        } else {
            throw new Exception("Parameters not passed properly");
        }
    }

    /**
     * @param string $table takes tablename as string
     * @param int $prKey primary key of the record to delete
     */
    public static function delete($table, $prKey)
    {
        if (!empty($table) && !empty($prKey)) {
            $sql = "DELETE FROM {$table} WHERE id={$prKey}";
            return $sql;
        } else {
            throw new Exception("Parameters not passed properly");
         }
    }
}
