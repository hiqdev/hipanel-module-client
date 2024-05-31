import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import WhitelistCategory from "@hipanel-module-client/helper/category/WhitelistCategory";

test("Correct view Whitelist @hipanel-module-client @admin", async ({ adminPage }) => {

    const blacklistHelper = new BlacklistHelper(adminPage, new WhitelistCategory());

    await blacklistHelper.gotoIndexBlacklist();

    let blacklist = await blacklistHelper.fillBlacklistFromIndexPage(1);
    await blacklistHelper.gotoBlacklistPage(1);
    await blacklistHelper.checkDetailViewData(blacklist);
});

