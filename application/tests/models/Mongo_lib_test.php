<?php

class Mongo_lib_test extends TestCase
{
	public $_id;
	public $data;
	public $table_name;

    public function setUp()
    {
        $this->obj = $this->newLibrary('mongo_db');
        $this->prepare_db();
    }

    private function prepare_db()
    {
    	echo PHP_EOL."Building test case data".PHP_EOL;
    	$this->_id = new MongoID('586c906c88f913ea5b8b4568');
		$this->data = array('_id'=>$this->_id, 'name'=>'intekhab');
		$this->table_name = 'phpunitest';
    }

    public function test_insert()
    {
    	echo PHP_EOL."Running : Insert query".PHP_EOL;
    	$result = $this->obj->insert($this->table_name, $this->data);
        $this->assertEquals($this->_id, $result);
    }

    public function test_get()
    {
    	echo PHP_EOL."Running : Get query".PHP_EOL;
    	$result = $this->obj->get($this->table_name);
    	$fetch = array($this->data);
        $this->assertEquals($fetch, $result);
    }

    public function test_select_get()
    {
    	echo PHP_EOL."Running : Select query".PHP_EOL;
    	$output = $this->data;
    	$result = $this->obj->select(array('name'))->get($this->table_name);
        $this->assertEquals(array($output), $result);
    }

	public function test_select_get2()
    {
    	echo PHP_EOL."Running : Select query type 2".PHP_EOL;
    	$output = $this->data;
    	unset($output['_id']);
    	$result = $this->obj->select(array('name'), array('_id'))->get($this->table_name);
        $this->assertEquals(array($output), $result);
    }

    public function test_where()
    {
    	echo PHP_EOL."Running : Where query".PHP_EOL;
    	$result = $this->obj->select(array('name'))
    	->where(array('_id'=>$this->_id))
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);
    }

    public function test_where_or()
    {
    	echo PHP_EOL."Running : Where_or query".PHP_EOL;
    	$exp = $this->data;
        $exp['not_exists'] = 'yes';

    	$result = $this->obj->select(array('name'))
    	->where_or($exp)
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);
    }

    public function test_where_in()
    {
		echo PHP_EOL."Running : Where_in query".PHP_EOL;
        $exp = array('name1', 'name2', $this->data['name']);
    	$result = $this->obj->select(array('name'))
    	->where_in('name', $exp)
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);
    }

    public function test_where_ne()
    {
    	echo PHP_EOL."Running : Where_ne query".PHP_EOL;
    	$result = $this->obj->select(array('name'))
    	->where_ne('name', 'non exists value')
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);
    }

    public function test_where_like()
    {
    	echo PHP_EOL."Running : Like query".PHP_EOL;
    	$result = $this->obj->select(array('name'))
    	->like('name', 'ntekha')
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);

        //Like Case sensitive testing
        $result = $this->obj->select(array('name'))
    	->like('name', 'ntekha', '')
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);

        //Like without front wild card
        $result = $this->obj->select(array('name'))
    	->like('name', 'intekha', 'i', TRUE)
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);

        //Like without endling wild card
        $result = $this->obj->select(array('name'))
    	->like('name', 'intekhab', 'i', TRUE, TRUE)
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);
    }

    public function test_get_where()
    {
    	echo PHP_EOL."Running : Get_where query".PHP_EOL;
    	$result = $this->obj->get_where($this->table_name, $this->data);
        $this->assertEquals(array($this->data), $result);

        $opt1 = $this->data;
        unset($opt1['_id']);
        $result = $this->obj->get_where($this->table_name, $opt1);
        $this->assertEquals(array($this->data), $result);
    }

    public function test_find_one()
    {
    	echo PHP_EOL."Running : Find_one query".PHP_EOL;
    	$result = $this->obj->find_one($this->table_name);
        $this->assertEquals($this->data, $result);
    }

    public function test_count()
    {
    	echo PHP_EOL."Running : Count query".PHP_EOL;
    	$result = $this->obj->count($this->table_name);
        $this->assertEquals(1, $result);

        //Count with where
        $opt1 = $this->data;
        unset($opt1['_id']);
        $result = $this->obj->where($opt1)->count($this->table_name);
        $this->assertEquals(1, $result);

        //Count with Like
        $result = $this->obj->select(array('name'))
    	->like('name', 'ntekha')
    	->count($this->table_name);
        $this->assertEquals(1, $result);

        //Count with Like Case sensitive testing
        $result = $this->obj->select(array('name'))
    	->like('name', 'ntekha', '')
    	->count($this->table_name);
        $this->assertEquals(1, $result);

        //Count with Like without front wild card
        $result = $this->obj->select(array('name'))
    	->like('name', 'intekha', 'i', TRUE)
    	->count($this->table_name);
        $this->assertEquals(1, $result);

        //Count with Like without endling wild card
        $result = $this->obj->select(array('name'))
    	->like('name', 'intekhab', 'i', TRUE, TRUE)
    	->count($this->table_name);
        $this->assertEquals(1, $result);

        //count with where not equal
        $result = $this->obj->select(array('name'))
    	->where_ne('name', 'non exists value')
    	->count($this->table_name);
        $this->assertEquals(1, $result);

        //Count with where in
        $exp = array('name1', 'name2', $this->data['name']);
    	$result = $this->obj->select(array('name'))
    	->where_in('name', $exp)
    	->count($this->table_name);
        $this->assertEquals(1, $result);
    }

    public function test_where_not_in()
    {
    	echo PHP_EOL."Running : where_not_in query".PHP_EOL;
        $exp = array('name1', 'name2');
    	$result = $this->obj->select(array('name'))
    	->where_not_in('name', $exp)
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);
    }

    public function test_set()
    {
    	echo PHP_EOL."Running : Set query".PHP_EOL;
    	$output = $this->data;
    	$output['last_name'] = 'rizvi';
    	$result = $this->obj->set(array('last_name'=>'rizvi'))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
        $this->assertEquals(array($output), $result);
    }

    public function test_addtoset()
    {
    	echo PHP_EOL."Running : addtoset query".PHP_EOL;
    	$result = $this->obj->addtoset('sports', array('football','cricket'))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('football','cricket');
        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
        $this->assertEquals(array($data), $result);
    }

    public function test_push()
    {
    	echo PHP_EOL."Running : Push query".PHP_EOL;
    	$result = $this->obj->push('address', array('l1'=>'l1','l2'=>'l2'))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

    	$result = $this->obj->push('sports', 'Swiming')
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('football','cricket','Swiming');
        $data['address'][0] = array('l1'=>'l1','l2'=>'l2');
        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
        $this->assertEquals(array($data), $result);
    }

    public function test_pop()
    {
    	echo PHP_EOL."Running : pop query".PHP_EOL;
    	$result = $this->obj->pop('sports')
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('cricket','Swiming');
        $data['address'][0] = array('l1'=>'l1','l2'=>'l2');
        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
        $this->assertEquals(array($data), $result);
    }

    public function test_pull()
    {
    	echo PHP_EOL."Running : Pull query".PHP_EOL;
    	$result = $this->obj->pull('address', array('l1'=>'l1'))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $result = $this->obj->pull('sports', 'cricket')
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        $data['address']= array();
        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);
    }

    public function test_rename_field()
    {
    	echo PHP_EOL."Running : rename query".PHP_EOL;
    	$result = $this->obj->rename_field('address','address2')
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        unset($data['address']);
        $data['address2'] = array();

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);
    }

    public function test_inc()
    {
    	echo PHP_EOL."Running : inc query".PHP_EOL;
    	$result = $this->obj->set('age',29)
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $result = $this->obj->inc('age',1)
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $result = $this->obj->inc(array('age'=>1))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        unset($data['address']);
        $data['address2'] = array();
        $data['age'] = 31;

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);
    }

    public function test_mul()
    {
    	echo PHP_EOL."Running : mul query".PHP_EOL;
        $result = $this->obj->mul('age',2)
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        unset($data['address']);
        $data['address2'] = array();
        $data['age'] = 62;

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);


        $result = $this->obj->mul(array('age'=>2))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        unset($data['address']);
        $data['address2'] = array();
        $data['age'] = 124;

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);
    }

    public function test_max()
    {
		echo PHP_EOL."Running : max query".PHP_EOL;
        $result = $this->obj->max('age',155)
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        unset($data['address']);
        $data['address2'] = array();
        $data['age'] = 155;

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);

        $result = $this->obj->max(array('age'=>160))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        unset($data['address']);
        $data['address2'] = array();
        $data['age'] = 160;

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);
    }

    public function test_min()
    {
    	echo PHP_EOL."Running : Minimum query Type 1".PHP_EOL;

        $result = $this->obj->min('age',150)
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        unset($data['address']);
        $data['address2'] = array();
        $data['age'] = 150;

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);

        echo PHP_EOL."Running : Minimum query Type 2".PHP_EOL;
        $result = $this->obj->min(array('age'=>29))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        unset($data['address']);
        $data['address2'] = array();
        $data['age'] = 29;

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
    	//var_dump($result);
        $this->assertEquals(array($data), $result);
    }

    public function test_where_gtlt()
    {
    	echo PHP_EOL."Running : gt, gte, lt, lte query".PHP_EOL;
    	$data = $this->data;
        $data['last_name'] = 'rizvi';
        $data['sports'] = array('Swiming');
        $data['address2'] = array();
        $data['age'] = 29;

    	$result = $this->obj->where_gt('age', 20)
    	->get($this->table_name);
    	//var_dump($result);
    	$this->assertEquals(array($data), $result);

    	$result = $this->obj->where_gte('age', 29)
    	->get($this->table_name);
    	//var_dump($result);
    	$this->assertEquals(array($data), $result);

    	$result = $this->obj->where_lt('age', 30)
    	->get($this->table_name);
    	//var_dump($result);
    	$this->assertEquals(array($data), $result);

    	$result = $this->obj->where_lte('age', 29)
    	->get($this->table_name);
    	//var_dump($result);
    	$this->assertEquals(array($data), $result);

    	$result = $this->obj->where_between('age', 20, 30)
    	->get($this->table_name);
    	//var_dump($result);
    	$this->assertEquals(array($data), $result);

    	$result = $this->obj->where_between_ne('age', 20, 30)
    	->get($this->table_name);
    	//var_dump($result);
    	$this->assertEquals(array($data), $result);

    }

    public function test_unset_field()
    {
    	echo PHP_EOL."Running : unset query".PHP_EOL;
    	$result = $this->obj->unset_field(array('last_name', 'sports', 'address2', 'age'))
    	->where('_id', $this->_id)
    	->update($this->table_name);
        $this->assertEquals(true, $result);

        $result = $this->obj->where('_id', $this->_id)
    	->get($this->table_name);
        $this->assertEquals(array($this->data), $result);
    }

    public function test_batch_insert()
    {
    	echo PHP_EOL."Running : batch insert query".PHP_EOL;
    	$data[0] = array('_id'=>new MongoId('586c906c88f913ea5b8b4570'), 'name'=>'abc');
    	$data[1] = array('_id'=>new MongoId('586c906c88f913ea5b8b4571'), 'name'=>'xyz');
    	$result = $this->obj->batch_insert($this->table_name, $data);
    	//var_dump($result);
    	$compare[0] = $data[0]['_id'];
    	$compare[1] = $data[1]['_id'];
        $this->assertEquals($compare, $result);

        $data[0] = $this->data;
        $data[1] = array('_id'=>new MongoId('586c906c88f913ea5b8b4570'), 'name'=>'abc');
    	$data[2] = array('_id'=>new MongoId('586c906c88f913ea5b8b4571'), 'name'=>'xyz');
        $result = $this->obj->get($this->table_name);
        //var_dump($result);
        $this->assertEquals($data, $result);

    }

    public function test_aggregate()
    {
    	echo PHP_EOL."Running : aggregate query".PHP_EOL;
    	$agg = array(
    		array('$match'=>array('name'=>'intekhab'))
    	);
    	$result = $this->obj->aggregate($this->table_name, $agg);
    	unset($result['waitedMS']);
    	unset($result['ok']);
    	//var_dump($result);
        $this->assertEquals(array('result'=>array($this->data)), $result);

    }

    public function test_order_by_limit()
    {
    	echo PHP_EOL."Running : order_by and limit query".PHP_EOL;
    	$result = $this->obj->order_by(array('name'=>'ASC'))->get($this->table_name);
    	//var_dump($result);
    	$data[1] = $this->data;
        $data[0]= array('_id'=>new MongoId('586c906c88f913ea5b8b4570'), 'name'=>'abc');
    	$data[2] = array('_id'=>new MongoId('586c906c88f913ea5b8b4571'), 'name'=>'xyz');
        $this->assertEquals($data, $result);

        $result = $this->obj->order_by(array('name'=>'DESC'))->get($this->table_name);
    	//var_dump($result);
    	$data[1] = $this->data;
        $data[2]= array('_id'=>new MongoId('586c906c88f913ea5b8b4570'), 'name'=>'abc');
    	$data[0] = array('_id'=>new MongoId('586c906c88f913ea5b8b4571'), 'name'=>'xyz');
        $this->assertEquals($data, $result);

        $result = $this->obj->order_by(array('name'=>'ASC'))->limit(1)->get($this->table_name);
    	//var_dump($result);
    	unset($data);
        $data[0]= array('_id'=>new MongoId('586c906c88f913ea5b8b4570'), 'name'=>'abc');
        $this->assertEquals($data, $result);

        $result = $this->obj->order_by(array('name'=>'DESC'))->limit(1)->get($this->table_name);
    	//var_dump($result);
    	unset($data);
    	$data[0] = array('_id'=>new MongoId('586c906c88f913ea5b8b4571'), 'name'=>'xyz');
        $this->assertEquals($data, $result);

    }

    public function test_indexes()
    {
    	echo PHP_EOL."Running : build, get and delete index query".PHP_EOL;
    	$result = $this->obj->add_index($this->table_name, array('name'=>1));
    	$this->assertEquals(true, $result);

		$result = $this->obj->list_indexes($this->table_name);
		//var_dump($result);
		$key[0] = array('name'=>'_id_', 'v'=>1, 'key'=>array('_id'=>1), 'ns'=>'mydb_test.phpunitest');
		$key[1] = array('name'=>'name_1', 'v'=>1, 'key'=>array('name'=>1), 'ns'=>'mydb_test.phpunitest');
		$this->assertEquals($key, $result);

		$result = $this->obj->remove_index($this->table_name, array('name'=>1));
		$this->assertEquals(true, $result);

		$result = $this->obj->list_indexes($this->table_name);
		//var_dump($result);
		unset($key);
		$key[0] = array('name'=>'_id_', 'v'=>1, 'key'=>array('_id'=>1), 'ns'=>'mydb_test.phpunitest');
		
		$this->assertEquals($key, $result);

    }

    public function test_delete()
    {
    	echo PHP_EOL."Running : delete query".PHP_EOL;
    	$result = $this->obj->where(array('_id'=>$this->_id))->delete($this->table_name);
        $this->assertEquals(true, $result);
    }

    public function test_delete_all()
    {
    	echo PHP_EOL."Running : delete all query".PHP_EOL;
    	$result = $this->obj->delete($this->table_name);
        $this->assertEquals(true, $result);
    }

    public function test_drop_collection()
    {
    	echo PHP_EOL."Running : drop collection query".PHP_EOL;
    	$result = $this->obj->drop_collection($this->table_name);
        $this->assertEquals(true, $result);
    }
}
