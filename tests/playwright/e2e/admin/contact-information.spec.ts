import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";

const assumptions = [
  { "name_with_verification": "Test Admin" },
  { "organization": "HiQDev" },
  { "email_with_verification": "hipanel_test_admin@hiqdev.com" },
  { "abuse_email": "hipanel_test_admin+abuse@hiqdev.com" },
  { "messengers": "Skype: hipanel_test_admin" },
  { "messengers": "ICQ:" },
  { "messengers": "Jabber: hipanel_test_admin@hiqdev.com" },
  { "messengers": "Telegram: hipanel_test_admin" },
  { "messengers": "WhatsApp: 123456789012" },
  { "social_net": "https://facebook.com/hipanel_test_admin" },
  { "voice_phone": "123456789012" },
  { "fax_phone": "987654321098" },
  { "street": "42 Test str." },
  { "city": "Test" },
  { "province": "Testing" },
  { "postal_code": "TEST" },
  { "country_name": "Trinidad And Tobago" },
];

test("Test the admin contact information is correct @hipanel-module-client @admin", async ({ adminPage }) => {
  await adminPage.goto("/site/profile");
  assumptions.map(
    async assumption => {
      let id = Object.keys(assumption)[0], text = assumption[id];
      await expect(adminPage.locator(`th[data-resizable-column-id=${id}] + td`)).toContainText(text);
    });
});
