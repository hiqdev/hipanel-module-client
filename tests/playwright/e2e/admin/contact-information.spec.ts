import { test } from "@hipanel-core/fixtures";
import {expect, Page} from "@playwright/test";

const contactInfoAssumptions = [
  { id: "name_with_verification", value: "Test Admin" },
  { id: "organization", value: "HiQDev" },
  { id: "email_with_verification", value: "hipanel_test_admin@hiqdev.com" },
  { id: "abuse_email", value: "hipanel_test_admin+abuse@hiqdev.com" },
  { id: "messengers", value: "Skype: hipanel_test_admin" },
  { id: "messengers", value: "ICQ:" },
  { id: "messengers", value: "Jabber: hipanel_test_admin@hiqdev.com" },
  { id: "messengers", value: "Telegram: hipanel_test_admin" },
  { id: "messengers", value: "WhatsApp: 123456789012" },
  { id: "social_net", value: "https://facebook.com/hipanel_test_admin" },
  { id: "voice_phone", value: "123456789012" },
  { id: "fax_phone", value: "987654321098" },
  { id: "street", value: "42 Test str." },
  { id: "city", value: "Test" },
  { id: "province", value: "Testing" },
  { id: "postal_code", value: "TEST" },
  { id: "country_name", value: "Trinidad And Tobago" },
];

test("Test the admin contact information is correct @hipanel-module-client @admin", async ({ adminPage }) => {
  // The `/site/profile` page redirects to `/client/client/view`, which can take more than 10 seconds to load. Previously,
  // this caused a timeout error after 10 seconds, so the timeout has been increased. See issue HP-2797 for more details.
  await adminPage.goto("/site/profile", {timeout: 50_000});
  await verifyContactInfo(adminPage, contactInfoAssumptions);
});

async function verifyContactInfo(page: Page, assumptions) {
  for (const assumption of assumptions) {
    const { id, value } = assumption;

    const locator = page.locator(`th[data-resizable-column-id=${id}] + td`);
    await expect(locator).toContainText(value);
  }
}
