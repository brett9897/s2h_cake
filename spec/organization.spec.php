<?php
# class CakeSpec
	describe "Organization"
		context "with fixture"
			before
				$W->fixtures = array('app.organization');
			end
			describe "#findByName"
				subject
					$organization = ClassRegistry::init('Organization');
					$result = $organization->findByName('test_org');
					return $result['Organization']['name'];
				end
				it "name"
					should equal 'test_org'
				end
			end
		end
	end
?>