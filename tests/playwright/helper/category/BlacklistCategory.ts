export default class BlacklistCategory implements BlacklistCategoryInterface {
  getName(): string {
    return "blacklist";
  }

  getLabel(): string {
    return "Blacklist";
  }
}
