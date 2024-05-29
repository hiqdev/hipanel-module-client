import { test } from "@hipanel-core/fixtures";
import BlacklistHelper from "@hipanel-module-client/helper/Blacklist";
import BlacklistCategory from "@hipanel-module-client/helper/category/BlacklistCategory";

test("Correct view Blacklist @hipanel-module-client @admin", async ({ adminPage }) => {
    const blacklistHelper = new BlacklistHelper(adminPage);
    await blacklistHelper.gotoIndexBlacklist(new BlacklistCategory());

    await blacklistHelper.hasMainElementsOnIndexPage();
});
