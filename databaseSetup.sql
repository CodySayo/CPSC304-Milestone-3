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
    RuneName Char PRIMARY KEY, 
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
    Cooldown integer, 
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