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
         function testSetId()
         {
           //Arrange
           $id = 1;
           $description = "Wash the puppy";
           $test_task = new Task($description, $id);
           //Act
           $test_task->setId(2);
           //Assert
           $result = $test_task->getId();
           $this->assertEquals(2, $result);
         }
         function testSaveSetId()
         {
           //Arrange
           $description = "Wash the puppy";
           $id = null;
           $test_task = new Task($description, $id);
           //Act
           $test_task->save();
           //Assert
           $this->assertEquals(true, is_numeric($test_task->getId()));
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
         function testAddCategory()
         {
           //Arrange
           $name = "Work stuff";
           $id = 1;
           $test_category = new Category($name, $id);
           $test_category->save();

           $description = "File reports";
           $id2 = 2;
           $due = "2019-03-03";
           $test_task = new Task($description, $id2, $due);
           $test_task->save();
           //Act
           $test_task->addCategory($test_category);
           //Assert
           $this->assertEquals($test_task->categories(), [$test_category]);
         }
         function testCategories()
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
           $due = "2019-02-02";
           $test_task = new Task($description, $id3, $due);
           $test_task->save();
           //Act
           $test_task->addCategory($test_category);
           $test_task->addCategory($test_category2);
           //Assert
           $this->assertEquals($test_task->categories(), [$test_category, $test_category2]);
         }
         function testDelete()
         {
           //Arrange
           $name = "Work stuff";
           $id = 1;
           $test_category = new Category($name, $id);
           $test_category->save();

           $description = "File reports";
           $id2 = 2;
           $due = "2019-03-03";
           $test_task = new Task($description, $id2, $due);
           $test_task->save();
           //Act
           $test_task->addCategory($test_category);
           $test_task->delete();
           //Assert
           $this->assertEquals([], $test_category->tasks());
         }

     }

 // ?>
