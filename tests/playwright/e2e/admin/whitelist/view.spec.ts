import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import WhitelistCategory from "@hipanel-module-client/helper/category/WhitelistCategory";

test("Correct view Whitelist @hipanel-module-client @admin", async ({ adminPage }) => {

    const blacklistHelper = new BlacklistHelper(adminPage);

    await blacklistHelper.gotoIndexBlacklist(new WhitelistCategory());

    await blacklistHelper.gotoBlacklistPage(1);
    let blacklist = await blacklistHelper.fillBlacklistFromIndexPage(1);

    await blacklistHelper.checkDetailViewData(blacklist);
});

