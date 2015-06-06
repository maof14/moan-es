<?php 

// TQueryBuilder. Simple query builder for SQL. 

Trait TQueryBuilder {

	private $sql;
	private $prefix;    // Prefix to attach to all table names

	private $columns;
	private $from;
	private $where;
	private $andWhere;

	/**
     * Get SQL.
     *
     * @return string as sql-query
     */

    public function getSQL()
    {
        if ($this->sql) {
            return $this->sql;
        } else {
            return $this->build();
        }
    }

    /**
     * Build SQL.
     *
     * @return string as SQL query
     */

    protected function build()
    {
        $sql = "SELECT\n\t"
            . $this->columns . "\n"
            . $this->from . "\n"
            . ($this->where   ? $this->where . "\n"   : null)
            . ";";
        return $sql;
    }

	public function select($columns = '*') {
		$this->clear();
        $this->columns = $columns;
		return $this;
	}

	public function from($table) {
		$this->from = 'FROM ' . $table . ' ';
		return $this;
	}

	public function where($oneCondition = array()) {
		$str = null;
		foreach($oneCondition as $key => $val) {
			if(is_string($val)) {
				$val = '\'' . $val . '\'';
			}
			$str = $key . ' = ' . $val . ' ';
		}
		$this->where .= 'WHERE ' . $str;
		return $this;
	}

	public function andWhere($oneCondition = array()) {
		$str = null;
		foreach($oneCondition as $key => $val) {
			$str = $key . ' = ' . $val . ' ';
		}
		$this->andWhere .= 'AND WHERE ' . $str;
		return $this;
	}

	/**
	 *
	 * Clear the queries. 
	 * @return void.
	 */

    protected function clear()
    {
        $this->sql      = null;
        $this->columns  = null;
        $this->from     = null;
        // $this->join     = null;
        $this->where    = null;
        // $this->groupby  = null;
        // $this->orderby  = null;
        // $this->limit    = null;
        // $this->offset   = null;
    }

    /**
     * Utilitie to check if array is associative array.
     *
     * http://stackoverflow.com/questions/173400/php-arrays-a-good-way-to-check-if-an-array-is-associative-or-sequential/4254008#4254008
     *
     * @param array $array input array to check.
     *
     * @return boolean true if array is associative array with at least one key, else false.
     *
     */
    private function isAssoc($array)
    {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }

    /**
     * Create a proper column value arrays from incoming $columns and $values.
     *
     * @param array  $columns
     * @param array  $values
     *
     * @return list($columns, $values)
     */
    public function mapColumnsWithValues($columns, $values)
    {
        // If $values is null, then use $columns to build it up
        if (is_null($values)) {

            if ($this->isAssoc($columns)) {

                // Incoming is associative array, split it up in two
                $values = array_values($columns);
                $columns = array_keys($columns);

            } else {

                // Create an array of '?' to match number of columns
                for ($i = 0; $i < count($columns); $i++) {
                    $values[] = '?';
                }
            }
        }

        return [$columns, $values];
    }



    /**
     * Build a insert-query.
     *
     * @param string $name    the table name.
     * @param array  $columns to insert och key=>value with columns and values.
     * @param array  $values  to insert or empty if $columns has bot columns and values.
     *
     * @return void
     */
    public function insert($table, $columns, $values = null)
    {
        list($columns, $values) = $this->mapColumnsWithValues($columns, $values);

        if (count($columns) != count($values)) {
            throw new \Exception("Columns does not match values, not equal items.");
        }

        $cols = null;
        $vals = null;

        for ($i = 0; $i < count($columns); $i++) {
            $cols .= $columns[$i] . ', ';

            $val = $values[$i];

            if ($val == '?') {
                $vals .= $val . ', ';
            } else {
                $vals .= (is_string($val)
                    ? "'$val'"
                    : $val)
                    . ', ';
            }
        }

        $cols = substr($cols, 0, -2);
        $vals = substr($vals, 0, -2);

        $this->sql = "INSERT INTO "
            . $this->prefix
            . $table
            . "\n\t("
            . $cols
            . ")\n"
            . "\tVALUES\n\t("
            . $vals
            . ");\n";
    }



    /**
     * Build an update-query.
     *
     * @param string $name    the table name.
     * @param array  $columns to update or key=>value with columns and values.
     * @param array  $values  to update or empty if $columns has bot columns and values.
     * @param array  $where   limit which rows are updated.
     *
     * @return void
     */
    public function update($table, $columns, $values = null, $where = null)
    {
        // If $values is string, then move that to $where
        if (is_string($values)) {
            $where = $values;
            $values = null;
        }

        list($columns, $values) = $this->mapColumnsWithValues($columns, $values);

        if (count($columns) != count($values)) {
            throw new \Exception("Columns does not match values, not equal items.");
        }

        $cols = null;

        for ($i = 0; $i < count($columns); $i++) {
            $cols .= "\t" . $columns[$i] . ' = ';

            $val = $values[$i];
            if ($val == '?') {
                $cols .= $val . ",\n";
            } else {
                $cols .= (is_string($val)
                    ? "'$val'"
                    : $val)
                    . ",\n";
            }
        }

        $cols = substr($cols, 0, -2);

        $this->sql = "UPDATE "
            . $this->prefix
            . $table
            . "\nSET\n"
            . $cols
            . "\nWHERE "
            . $where
            . "\n;\n";
    }

}