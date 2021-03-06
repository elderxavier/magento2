<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\CatalogRule\Test\TestCase;

use Magento\CatalogRule\Test\Fixture\CatalogRule;

/**
 * Test Creation for Create CatalogPriceRuleEntity
 *
 * Test Flow:
 * 1. Log in as default admin user.
 * 2. Go to Marketing > Catalog Price Rules
 * 3. Press "+" button to start create new catalog price rule
 * 4. Fill in all data according to data set
 * 5. Save rule
 * 6. Perform appropriate assertions
 *
 * @group Catalog_Price_Rules_(MX)
 * @ZephyrId MAGETWO-24341
 */
class CreateCatalogPriceRuleEntityTest extends AbstractCatalogRuleEntityTest
{
    /**
     * Create Catalog Price Rule
     *
     * @param CatalogRule $catalogPriceRule
     * @return void
     */
    public function testCreateCatalogPriceRule(CatalogRule $catalogPriceRule)
    {
        // Steps
        $this->catalogRuleIndex->open();
        $this->catalogRuleIndex->getGridPageActions()->addNew();
        $this->catalogRuleNew->getEditForm()->fill($catalogPriceRule);
        $this->catalogRuleNew->getFormPageActions()->save();

        // Prepare data for tear down
        $this->catalogRules[] = $catalogPriceRule;
    }
}
