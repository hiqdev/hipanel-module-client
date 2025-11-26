import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import BlacklistCategory from "@hipanel-module-client/helper/category/BlacklistCategory";
import { Blacklist } from "@hipanel-module-client/types";

const blacklistItemForTestView: Blacklist = {
  name: "blacklist_test_view_item",
  type: "Domain",
  message: "Test Blacklist view page",
  showMessage: "Yes",
};

test("Correct view Blacklist @hipanel-module-client @admin", async ({ adminPage }) => {
  const blacklistHelper = new BlacklistHelper(adminPage, new BlacklistCategory());

  await blacklistHelper.gotoIndexBlacklist();

  if (await blacklistHelper.getRowsOnIndexPage() === 0) {
    blacklistItemForTestView.id = await blacklistHelper.createBlacklist(new BlacklistCategory(), blacklistItemForTestView);
    await blacklistHelper.gotoIndexBlacklist();
  }

  const blacklist = await blacklistHelper.fillBlacklistFromIndexPage(1);
  await blacklistHelper.gotoBlacklistPage(1);

  await blacklistHelper.checkDetailViewData(blacklist);

  if (blacklistItemForTestView.id) {
    await blacklistHelper.deleteBlacklist(blacklistItemForTestView.id);
  }
});
