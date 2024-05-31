import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import WhitelistCategory from "@hipanel-module-client/helper/category/WhitelistCategory";
import Blacklist from "@hipanel-module-client/model/Blacklist";

const blacklist = new Blacklist();
blacklist['name'] = 'blacklist_test_item';
blacklist['type'] = 'Domain';
blacklist['message'] = 'Test Blacklist';
blacklist['showMessage'] = 'Yes';

test("Correct CRUD Whitelist @hipanel-module-client @osrc", async ({ osrcPage }) => {
    const blacklistHelper = new BlacklistHelper(osrcPage, new WhitelistCategory());
    await blacklistHelper.gotoIndexBlacklist();

    const blacklistId = await blacklistHelper.createBlacklist(new WhitelistCategory(), blacklist);
    blacklist['id'] = blacklistId;

    await blacklistHelper.checkDetailViewData(blacklist);

    await blacklistHelper.gotoIndexBlacklist();

    if (blacklistId) {
        await blacklistHelper.deleteBlacklist(blacklistId);
    }
});
