import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import BlacklistCategory from "@hipanel-module-client/helper/category/BlacklistCategory";

test("Correct view Blacklist @hipanel-module-client @admin", async ({ adminPage }) => {

    const blacklistHelper = new BlacklistHelper(adminPage, new BlacklistCategory());

    await blacklistHelper.gotoIndexBlacklist();

    await blacklistHelper.gotoBlacklistPage(1);
    let blacklist = await blacklistHelper.fillBlacklistFromIndexPage(1);

    await blacklistHelper.checkDetailViewData(blacklist);
});
