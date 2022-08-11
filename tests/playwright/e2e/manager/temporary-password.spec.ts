import { test } from "@hipanel-core/tests/fixtures";
import { expect } from "@playwright/test";

test("Test the temporary password pop-up is work @hipanel-module-client @manager", async ({ managerPage }) => {
  await managerPage.goto("/client/client/index");
  await expect(managerPage).toHaveURL("/client/client/index");
  await managerPage.locator("[placeholder=\"Login or Email\"]").fill("hipanel_test_user");
  await Promise.all([
    managerPage.waitForNavigation(),
    managerPage.locator("[placeholder=\"Login or Email\"]").press("Enter"),
  ]);
  await Promise.all([
    managerPage.waitForNavigation(),
    managerPage.locator("a:has-text(\"hipanel_test_user\")").first().click(),
  ]);
  await expect(managerPage).toHaveTitle("hipanel_test_user");
  await managerPage.locator("a:has-text(\"Temporary password\")").click();
  await expect(managerPage.locator("h4:has-text(\"Temporary password\")")).toBeVisible();
  await managerPage.waitForSelector("#tmp-password-form >> text=Confirm");
  await managerPage.locator("#tmp-password-form >> text=Confirm").click();
  await managerPage.waitForSelector("div[role=\"alert\"]");
  await managerPage.locator("text=Temporary password was sent on your email").click();
});
