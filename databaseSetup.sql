DROP TABLE Match CASCADE CONSTRAINTS;
DROP TABLE Keystones CASCADE CONSTRAINTS;
DROP TABLE Runes CASCADE CONSTRAINTS;
DROP TABLE Champions CASCADE CONSTRAINTS;
DROP TABLE Abilities;
DROP TABLE Roles CASCADE CONSTRAINTS;
DROP TABLE Items CASCADE CONSTRAINTS;
DROP TABLE ConsumableItems;
DROP TABLE MythicItems;
DROP TABLE ActiveItems;
DROP TABLE Spells CASCADE CONSTRAINTS;
DROP TABLE HasSpells;
DROP TABLE "User" CASCADE CONSTRAINTS;
DROP TABLE BuysItem CASCADE CONSTRAINTS;
DROP TABLE RunePage CASCADE CONSTRAINTS;
DROP TABLE RunesInPage CASCADE CONSTRAINTS;

CREATE TABLE Match(
    MatchID Integer PRIMARY KEY, 
    dateOfMatch Char(30)
);

CREATE TABLE Keystones(
    Keystone Char(30) PRIMARY KEY, 
    KeystoneEffect Char(200), 
    PrimaryPath Char(30)
);

CREATE TABLE Runes(
    RuneName Char(30) PRIMARY KEY, 
    Effect Char(200), 
    Path Char(30)
);

CREATE TABLE Champions(
    Name Char(30) PRIMARY KEY, 
    Armor integer, 
    MagicResist integer, 
    AttackDamage integer, 
    Health integer, 
    MovementSpeed integer
);

CREATE TABLE Abilities(
    AbilityName Char(30) PRIMARY KEY, 
    Passive Char(200), 
    Cooldown Char(30), 
    Type Char(100), 
    ChampionName Char(30) NOT NULL,
    FOREIGN KEY (ChampionName) REFERENCES Champions(Name) 
);

CREATE TABLE Roles(
	Role Char(30) PRIMARY KEY,
	Lane Char(30)
);

CREATE TABLE Items(
    ItemName Char(30) PRIMARY KEY,
    AttackDamage Integer,
    Armor Integer,
    AbilityPower Integer,
    MagicResist Integer,
    LifeSteal Integer,
    AttackSpeed Integer,
    CritChance Integer,
    Health Integer,
    MovementSpeed Integer,
    Cost Integer
);

CREATE TABLE ConsumableItems(
    ItemName Char(30) PRIMARY KEY, 
    NumUses Integer
);

CREATE TABLE MythicItems(
    ItemName Char(30) PRIMARY KEY, 
    Passive Char(200)
);

CREATE TABLE ActiveItems(
    ItemName Char(30) PRIMARY KEY, 
    Cooldown Integer
);

 CREATE TABLE Spells(
    SpellName Char(30) PRIMARY KEY,
    SpellEffect Char(200), 
    SpellCooldown Integer
);

CREATE TABLE "User"(
    UserID Integer, 
    Team Char(5), 
    MatchID Integer, 
    Victory Char(5), 
    Kills Integer, 
    Deaths Integer, 
    Assists Integer, 
    ChampionName Char(30) NOT NULL, 
    Role Char(30),
    PRIMARY KEY (UserID, Team, MatchID),
    FOREIGN KEY (MatchID) REFERENCES Match(MatchID)
        ON DELETE CASCADE,
    FOREIGN KEY (Role) REFERENCES Roles(Role),
    FOREIGN KEY (ChampionName) REFERENCES Champions(Name)
);

CREATE TABLE HasSpells(
    SpellName Char(30), 
    UserID Integer NOT NULL, 
    Team Char(5) NOT NULL, 
    MatchID Integer NOT NULL,
    PRIMARY KEY (SpellName, UserID, Team, MatchID),
    FOREIGN KEY (SpellName) 
        REFERENCES Spells ON DELETE CASCADE,
    FOREIGN KEY (UserID, Team, MatchID) 
        REFERENCES "User"(UserID, Team, MatchID) ON DELETE CASCADE
);

CREATE TABLE BuysItem(
    ItemName Char(30),
        UserID Integer,
    Team Char(5),
    MatchID Integer,
    PRIMARY KEY (ItemName, UserID, Team),
    FOREIGN KEY (ItemName) REFERENCES Items(ItemName),
    FOREIGN KEY (UserID, Team, MatchID) REFERENCES "User"(UserID, Team, MatchID)
);

CREATE TABLE RunePage(
    SecondaryPath Char(30), 
    PageName Char(30), 
    Keystone Char(30), 
    PageID Integer PRIMARY KEY,
    UserID Integer, 
    Team Char(5),
    MatchID Integer,
    FOREIGN KEY (Team, UserID, MatchID) REFERENCES "User"(Team, UserID, MatchID)
    ON DELETE CASCADE,
    FOREIGN KEY (Keystone) REFERENCES Keystones(Keystone)
);

CREATE TABLE RunesInPage(
    PageID Integer PRIMARY KEY, 
    RuneName Char(30),
    FOREIGN KEY (PageID) REFERENCES RunePage(PageID),
    FOREIGN KEY (RuneName) REFERENCES Runes(RuneName)
);

INSERT INTO Match(MatchID, DateOfMatch) VALUES (4564124, '2020-09-15');
INSERT INTO Match(MatchID, DateOfMatch) VALUES (2345678, '2020-08-21');
INSERT INTO Match(MatchID, DateOfMatch) VALUES (2345670, '2020-08-30');
INSERT INTO Match(MatchID, DateOfMatch) VALUES (3456789, '2020-07-25');
INSERT INTO Match(MatchID, DateOfMatch) VALUES (2377788, '2020-06-07');

INSERT INTO Keystones(Keystone, KeystoneEffect, PrimaryPath) VALUES 
('Electrocute', 'Attack an enemy 3 times within 3 seconds to deal bonus damage', 'Domination');
INSERT INTO Keystones(Keystone, KeystoneEffect, PrimaryPath) VALUES 
('Arcane Comet', 'Damage an enemy with an ability to hurl a damaging magic comet', 'Sorcery');
INSERT INTO Keystones(Keystone, KeystoneEffect, PrimaryPath) VALUES 
('Hail of Blades', 'Attack an enemy to gain bonus attack speed and temporarily increase the attack speed cap', 'Domination');
INSERT INTO Keystones(Keystone, KeystoneEffect, PrimaryPath) VALUES 
('Aftershock', 'Immobilize an enemy to gain bonus armor and magic resist for a short duration. After the duration, send out a damaging shockwave', 'Resolve');
INSERT INTO Keystones(Keystone, KeystoneEffect, PrimaryPath) VALUES 
('Lethal Tempo', 'Increase your attack speed cap and gain bonus attack speed shortly after damaging an enemy', 'Precision');

INSERT INTO Runes(RuneName, Path, Effect) VALUES 
('Coup de Grace', 'Precision', 'Deal more damage to low health enemy champions');
INSERT INTO Runes(RuneName, Path, Effect) VALUES 
('Overheal', 'Precision', 'Excess healing on you becomes a shield');
INSERT INTO Runes(RuneName, Path, Effect) VALUES 
('Waterwalking', 'Sorcery', 'Gain MS and AP or AD, adaptive in the river');
INSERT INTO Runes(RuneName, Path, Effect) VALUES 
('Magical Footwear', 'Inspiration', 'Get free boots at 12 min but you cannot buy boots before then');
INSERT INTO Runes(RuneName, Path, Effect) VALUES 
('Conditioning', 'Resolve', 'After 12 minutes, gain bonus armor and magic resist');

INSERT INTO Champions(Name, Armor, MagicResist, AttackDamage, Health, MovementSpeed) VALUES 
('Fizz', 22, 32, 58, 570, 335);
INSERT INTO Champions(Name, Armor, MagicResist, AttackDamage, Health, MovementSpeed) VALUES 
('Jax', 39, 32, 63, 565, 335);
INSERT INTO Champions(Name, Armor, MagicResist, AttackDamage, Health, MovementSpeed) VALUES 
('Zed', 32, 32, 63, 584, 345);
INSERT INTO Champions(Name, Armor, MagicResist, AttackDamage, Health, MovementSpeed) VALUES 
('Vi', 30, 32, 63, 585, 340);
INSERT INTO Champions(Name, Armor, MagicResist, AttackDamage, Health, MovementSpeed) VALUES 
('Tristana', 26, 30, 61, 559, 325);

INSERT INTO Abilities(AbilityName, Passive, Cooldown, Type, ChampionName) VALUES 
('Leap Strike', null, '8/7.5/7/6.5/6', 'Dash, Damage', 'Jax');
INSERT INTO Abilities(AbilityName, Passive, Cooldown, Type, ChampionName) VALUES 
('Empower', null, '7/6/5/4/3', 'Damage', 'Jax');
INSERT INTO Abilities(AbilityName, Passive, Cooldown, Type, ChampionName) VALUES 
('Counter Strike', null, '14/12.5/11/9.5/8', 'Dodge, Stun', 'Jax');
INSERT INTO Abilities(AbilityName, Passive, Cooldown, Type, ChampionName) VALUES 
('Grandmasters Might', 'Every third consecutive attack deals additional magic damage', '80', 'Armor, Magic Resist', 'Jax');
INSERT INTO Abilities(AbilityName, Passive, Cooldown, Type, ChampionName) VALUES 
('Urchin Strike', null, '8/7.5/7/6.5/6', 'Dash, Damage', 'Fizz');

INSERT INTO Roles(Role, Lane) VALUES
('Assassin', 'Mid');
INSERT INTO Roles(Role, Lane) VALUES
('Bruiser', 'Top');
INSERT INTO Roles(Role, Lane) VALUES
('Tank', 'Jungle');
INSERT INTO Roles(Role, Lane) VALUES
('Marksman', 'Bot');
INSERT INTO Roles(Role, Lane) VALUES
('Enchanter', 'Bot');

INSERT INTO Items VALUES
('Bilgewater Cutlass', 25, 0, 0, 0, 10, 0, 0, 0, 0, 1600);
INSERT INTO Items VALUES
('Refillable Potion', 0, 0, 0, 0, 0, 0, 0, 0, 0, 150);
INSERT INTO Items VALUES
('Galeforce', 55, 0, 0, 0, 0, 20, 20, 0, 0, 3400);
INSERT INTO Items VALUES
('Force of Nature', 0, 0, 0, 55, 0, 0, 0, 350, 7, 2900);
INSERT INTO Items VALUES
('Kraken Slayer', 60, 0, 0, 0, 25, 20, 0, 0, 0, 3400);

INSERT INTO ConsumableItems VALUES
('Refillable Potion', 2);
INSERT INTO ConsumableItems VALUES
('Health Potion', 1);
INSERT INTO ConsumableItems VALUES
('Corrupting Potion', 3);
INSERT INTO ConsumableItems VALUES
('Control Ward', 1);
INSERT INTO ConsumableItems VALUES
('Elixir of Iron', 1);

INSERT INTO MythicItems VALUES
('Galeforce', 'Grants all other legendary items +3% Move Speed');
INSERT INTO MythicItems VALUES
('Kraken Slayer', 'Grants all other Legendary items +10% Attack Speed');
INSERT INTO MythicItems VALUES
('Immortal Shieldbow', 'Grants all other legendary items + 8 Armor and +8 Magic Resist');
INSERT INTO MythicItems VALUES
('Sunfire Aegis', 'Grants all other legendary items +5 Ability Haste');
INSERT INTO MythicItems VALUES
('Frostfire Gauntlet', 'Grants all other legendary items +100 health and +7.5% Size');

INSERT INTO ActiveItems VALUES
('Bilgewater Cutlass', 90);
INSERT INTO ActiveItems VALUES
('Hextech Gunblade', 40);
INSERT INTO ActiveItems VALUES
('Tiamat', 10);
INSERT INTO ActiveItems VALUES
('Titanic Hydra', 20);
INSERT INTO ActiveItems VALUES
('Ravenous Hydra', 10);

INSERT INTO Spells VALUES  
('Flash', 'Teleports your champion a short distance toward your cursors location', 300);
INSERT INTO Spells VALUES  
('Ghost', 'Your champion can move through units for 10 seconds, gaining increased Movement Speed', 210);
INSERT INTO Spells VALUES  
('Ignite', 'Ignites target enemy champion, dealing 70-410 true damage (depending on champion level) over 5 seconds and reduces healing', 180);
INSERT INTO Spells VALUES  
('Heal', 'Restores 90 - 345 Health (depending on champion level) to your champion and to nearby allies', 240);
INSERT INTO Spells VALUES  
('Teleport', 'After casting for 4 seconds, teleports your champion to target allied minion, turret, or ward', 420);

INSERT INTO "User"(UserID, Team, MatchID, Victory, Kills, Deaths, Assists, ChampionName, Role) VALUES 
(12454, 'Blue', 4564124, 'True', 12, 5, 5, 'Fizz', 'Assassin');
INSERT INTO "User"(UserID, Team, MatchID, Victory, Kills, Deaths, Assists, ChampionName, Role) VALUES 
(23456, 'Blue', 2345678, 'True', 3, 12, 1, 'Jax', 'Bruiser');
INSERT INTO "User"(UserID, Team, MatchID, Victory, Kills, Deaths, Assists, ChampionName, Role) VALUES 
(34567, 'Red', 2345678, 'True', 2, 1, 2, 'Vi', 'Bruiser');
INSERT INTO "User"(UserID, Team, MatchID, Victory, Kills, Deaths, Assists, ChampionName, Role) VALUES 
(45678, 'Blue', 3456789, 'True', 4, 1, 1, 'Tristana', 'Marksman');
INSERT INTO "User"(UserID, Team, MatchID, Victory, Kills, Deaths, Assists, ChampionName, Role) VALUES 
(13754, 'Red', 2377788, 'False', 0, 20, 0, 'Zed', 'Assassin');

INSERT INTO HasSpells VALUES  
('Flash', 12454, 'Blue', 4564124);
INSERT INTO HasSpells VALUES  
('Flash', 23456, 'Blue', 2345678);
INSERT INTO HasSpells VALUES  
('Ghost', 34567, 'Red', 2345678);
INSERT INTO HasSpells VALUES  
('Ignite', 34567, 'Red', 2345678);
INSERT INTO HasSpells VALUES  
('Heal', 45678, 'Blue', 3456789);

INSERT INTO BuysItem(ItemName, UserID, Team, MatchID) VALUES 
('Bilgewater Cutlass', 12454, 'Blue', 4564124);
INSERT INTO BuysItem(ItemName, UserID, Team, MatchID) VALUES 
('Refillable Potion', 23456, 'Blue', 2345678);
INSERT INTO BuysItem(ItemName, UserID, Team, MatchID) VALUES 
('Galeforce', 34567, 'Red', 2345678);
INSERT INTO BuysItem(ItemName, UserID, Team, MatchID) VALUES 
('Force of Nature', 45678, 'Blue', 3456789);
INSERT INTO BuysItem(ItemName, UserID, Team, MatchID) VALUES 
('Kraken Slayer', 13754, 'Red', 2377788);

INSERT INTO RunePage(SecondaryPath, PageName, Keystone, PageID, UserID, Team, MatchID) VALUES 
('Domination', 'Mid', 'Electrocute', 141415, 12454, 'Blue', 4564124);
INSERT INTO RunePage(SecondaryPath, PageName, Keystone, PageID, UserID, Team, MatchID) VALUES 
('Sorcery', 'Mid AP', 'Arcane Comet', 151516, 23456, 'Blue', 2345678);
INSERT INTO RunePage(SecondaryPath, PageName, Keystone, PageID, UserID, Team, MatchID) VALUES 
('Domination', 'Support', 'Hail of Blades', 255285, 34567, 'Red', 2345678);
INSERT INTO RunePage(SecondaryPath, PageName, Keystone, PageID, UserID, Team, MatchID) VALUES 
('Precision', 'Jungle', 'Lethal Tempo', 456271, 45678, 'Blue', 3456789);
INSERT INTO RunePage(SecondaryPath, PageName, Keystone, PageID, UserID, Team, MatchID) VALUES 
('Resolve', 'Top', 'Aftershock', 453695, 13754, 'Red', 2377788);

INSERT INTO RunesInPage(RuneName, PageID) VALUES 
('Coup de Grace', 141415);
INSERT INTO RunesInPage(RuneName, PageID) VALUES 
('Overheal', 151516);
INSERT INTO RunesInPage(RuneName, PageID) VALUES 
('Waterwalking', 255285);
INSERT INTO RunesInPage(RuneName, PageID) VALUES 
('Magical Footwear', 456271);
INSERT INTO RunesInPage(RuneName, PageID) VALUES 
('Conditioning', 453695);