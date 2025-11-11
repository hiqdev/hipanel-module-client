import { test } from "@hipanel-core/fixtures";
import Index from "@hipanel-core/page/Index";

test("Client export works correctly @hipanel-module-client @manager", async ({ page }) => {
  await page.goto("/client/client/index");

  const indexPage = new Index(page);
  await indexPage.testExport();
});
