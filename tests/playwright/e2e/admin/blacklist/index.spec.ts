import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import BlacklistCategory from "@hipanel-module-client/helper/category/BlacklistCategory";
import Index from "@hipanel-core/page/Index";

test("Blacklist export works correctly @hipanel-module-client @admin", async ({ page }) => {
  await page.goto("/client/blacklist/index");

  const indexPage = new Index(page);
  await indexPage.testExport();

});

test("Blacklist index page display correctly @hipanel-module-client @admin", async ({ adminPage }) => {
  const blacklistHelper = new BlacklistHelper(adminPage, new BlacklistCategory());
  await blacklistHelper.gotoIndexBlacklist();

  await blacklistHelper.hasMainElementsOnIndexPage();
});
