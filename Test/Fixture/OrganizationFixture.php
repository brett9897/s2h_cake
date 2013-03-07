<?PHP
/**
 * Organization Fixture
 *
 */
class OrganizationFixture extends CakeTestFixture
{
	public $import = array('table' => 'organizations', 'connection' => 'development');

	public $records = array(
		array(
			'name' => 'test_org',
			'isDeleted' => 0
		)
	);
}

 ?>