<?php

  /**
   * @backupGlobals disabled
   * @backupStaticAttributes disabled
   */

     require_once "src/Task.php";
     require_once "src/Category.php";

     $server = 'mysql:host=localhost;dbname=to_do_test';
     $username = 'root';
     $password = 'root';
     $DB = new PDO($server, $username, $password);

     class TaskTest extends PHPUnit_Framework_TestCase
     {
         protected function tearDown()
         {
           Task::deleteAll();
           Category::deleteAll();
         }

         function test_save()
         {
           //Arrange
           $name = "Home stuff";
           $id = null;
           $test_category = new Category($name, $id);
           $test_category->save();

           $description = "Wash the dog";
           $due = "2016-03-02";
           $test_task = new Task($description, $id, $due);

           //Act
           $test_task->save();
           //Assert
           $result = Task::getAll();
           $this->assertEquals($test_task, $result[0]);
         }
         function test_getAll()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $due = "2016-03-02";
             $test_task = new Task($description, $id, $due);
             $test_task->save();

             $description2 = "Water the lawn";
             $due2 = "2016-03-02";
             $test_task2 = new Task($description2, $id, $due2);
             $test_task2->save();

             //Act
             $result = Task::getAll();

             //Assert
            $this->assertEquals([$test_task, $test_task2], $result);
         }
         function test_deleteAll()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->Save();

             $description = "Wash the dog";
             $due = "2016-03-02";
             $test_task = new Task($description, $id, $due);
             $test_task->save();

             $description2 = "Water the lawn";
             $due = "2016-03-02";
             $test_task2 = new Task($description2, $id, $due);
             $test_task2->save();

             //Act
            Task::deleteAll();

             //Assert
             $result = Task::getAll();
             $this->assertEquals([], $result);
         }
         function test_getId()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $due = "2016-03-02";
             $test_task = new Task($description, $id, $due);
             $test_task->save();
             //Act
             $result = $test_task->getId();
             //Assert
             $this->assertEquals(true, is_numeric($result));
         }
         function test_find()
         {
           //Arrange
           $name = "Home stuff";
           $id = null;
           $test_category = new Category($name, $id);
           $test_category->save();

           $description = "Wash the dog";
           $due = "2016-03-02";
           $test_task = new Task($description, $id, $due);
           $test_task->save();

           $description2 = "Water the lawn";
           $due = "2016-03-02";
           $test_task2 = new Task($description2, $id, $due);
           $test_task2->save();
           //Act
           $result = Task::find($test_task->getId());
           //Assert
           $this->assertEquals($test_task, $result);
         }
         function test_getCategoryId()
         {
           //Arrange
           $name = "Home stuff";
           $id = null;
           $test_category = new Category($name, $id);
           $test_category->save();

           $description = "Wash the dog";
           $due = "2016-03-02";
           $test_task = new Task($description, $id, $due);
           $test_task->save();
           //Act
           $result = $test_task->getCategoryId();
           //Assert
           $this->assertEquals(true, is_numeric($result));
         }
         function testAddCategory()
         {
           //Arrange
           $name = "Work stuff";
           $id = 1;
           $test_category = new Category($name, $id);
           $test_category->save();

           $description = "File reports";
           $id2 = 2;
           $test_task = new Task($description, $id2);
           $test_task->save();
           //Act
           $test_task->addCategory($test_category);
           //Assert
           $this->assertEquals($test_task->getCategories(), [$test_category]);
         }
         function testGetCategories()
         {
           //Arrange
           $name = "Work stuff";
           $id = 1;
           $test_category = new Category($name, $id);
           $test_category->save();

           $name2 = "Volunteer stuff";
           $id2 = 2;
           $test_category2 = new Category($name2, $id2);
           $test_category2->save();

           $description = "File reports";
           $id3 = 3;
           $test_task = new Task($description, $id3);
           $test_task->save();
           //Act
           $test_task->addCategory($test_category);
           $test_task->addCategory($test_category2);
           //Assert
           $this->assertEquals($test_task->getCategories(), [$test_category, $test_cateogry2]);
         }

     }

 // ?>
