import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import WhitelistCategory from "@hipanel-module-client/helper/category/WhitelistCategory";
import { Blacklist } from "@hipanel-module-client/types";

const blacklist: Blacklist = {
  name: "blacklist_test_item",
  type: "Domain",
  message: "Test Blacklist",
  showMessage: "Yes",
};

test("Correct CRUD Whitelist @hipanel-module-client @admin", async ({ adminPage }) => {
  const blacklistHelper = new BlacklistHelper(adminPage, new WhitelistCategory());
  await blacklistHelper.gotoIndexBlacklist();

  const blacklistId = await blacklistHelper.createBlacklist(new WhitelistCategory(), blacklist);
  blacklist.id = blacklistId;

  await blacklistHelper.checkDetailViewData(blacklist);

  await blacklistHelper.gotoIndexBlacklist();

  if (blacklistId) {
    await blacklistHelper.deleteBlacklist(blacklistId);
  }
});
