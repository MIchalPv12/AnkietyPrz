

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Uzytkownicy`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Uzytkownicy` (
  `idUsers` INT NOT NULL AUTO_INCREMENT,
  `Login` VARCHAR(45) NULL,
  `Haslo` VARCHAR(45) NULL,
  `Imie` VARCHAR(45) NULL,
  `Nazwisko` VARCHAR(45) NULL,
  `Plec` TINYINT(1) NULL,
  `Data_urodzenia` DATE NULL,
  `Wojewodztwo` VARCHAR(45) NULL,
  `Adres_email` VARCHAR(45) NULL,
  `Data_zalozenia_konta` DATE NULL,
  `Wypelnione_ankiety` INT NULL,
  `Zamieszczone_ankiety` INT NULL,
  `Administrator` TINYINT(1) NULL,
  `Zablokowany` TINYINT(1) NOT NULL,
  PRIMARY KEY (`idUsers`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ankiety`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Ankiety` (
  `idAnkiety` INT NOT NULL AUTO_INCREMENT,
  `Tytul` VARCHAR(45) NULL,
  `Opis` VARCHAR(45) NULL,
  `Rodzaj_pytania` VARCHAR(45) NULL,
  `Anonimowosc` TINYINT(1) NULL,
  `Uzytkownicy_idUsers` INT NULL,
  PRIMARY KEY (`idAnkiety`),
  INDEX `fk_Ankiety_Uzytkownicy_idx` (`Uzytkownicy_idUsers` ASC),
  CONSTRAINT `fk_Ankiety_Uzytkownicy`
    FOREIGN KEY (`Uzytkownicy_idUsers`)
    REFERENCES `mydb`.`Uzytkownicy` (`idUsers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ankietowany`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Ankietowany` (
  `idAnkietowany` INT NOT NULL AUTO_INCREMENT,
  `Imie` VARCHAR(45) NULL,
  `Nazwisko` VARCHAR(45) NULL,
  `Wypelnione_ankiety` VARCHAR(45) NULL,
  PRIMARY KEY (`idAnkietowany`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Zaproszenia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Zaproszenia` (
  `idZaproszenia` INT NOT NULL AUTO_INCREMENT,
  `Tytul_ankiety` VARCHAR(45) NULL,
  `Wstep` VARCHAR(45) NULL,
  `Podziekowanie` VARCHAR(45) NULL,
  `Krotki_opis` VARCHAR(45) NULL,
  `Ankiety_idAnkiety` INT NOT NULL,
  `Ankietowany_idAnkietowany` INT NOT NULL,
  PRIMARY KEY (`idZaproszenia`),
  INDEX `fk_Zaproszenia_Ankiety1_idx` (`Ankiety_idAnkiety` ASC),
  INDEX `fk_Zaproszenia_Ankietowany1_idx` (`Ankietowany_idAnkietowany` ASC),
  CONSTRAINT `fk_Zaproszenia_Ankiety1`
    FOREIGN KEY (`Ankiety_idAnkiety`)
    REFERENCES `mydb`.`Ankiety` (`idAnkiety`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Zaproszenia_Ankietowany1`
    FOREIGN KEY (`Ankietowany_idAnkietowany`)
    REFERENCES `mydb`.`Ankietowany` (`idAnkietowany`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Wiadomosci`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Wiadomosci` (
  `idWiadomosci` INT NOT NULL AUTO_INCREMENT,
  `Tresc_wiad` VARCHAR(45) NULL,
  `Wiad_od` VARCHAR(45) NULL,
  `Wiad_do` VARCHAR(45) NULL,
  `Data` DATE NULL,
  `Temat` VARCHAR(45) NULL,
  `Uzytkownicy_idUsers` INT NOT NULL,
  PRIMARY KEY (`idWiadomosci`),
  INDEX `fk_Wiadomosci_Uzytkownicy1_idx` (`Uzytkownicy_idUsers` ASC),
  CONSTRAINT `fk_Wiadomosci_Uzytkownicy1`
    FOREIGN KEY (`Uzytkownicy_idUsers`)
    REFERENCES `mydb`.`Uzytkownicy` (`idUsers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Pytania`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Pytania` (
  `idPytania` INT NOT NULL AUTO_INCREMENT,
  `Tresc` VARCHAR(45) NULL,
  `Ankiety_idAnkiety` INT NOT NULL,
  PRIMARY KEY (`idPytania`),
  INDEX `fk_Pytania_Ankiety1_idx` (`Ankiety_idAnkiety` ASC),
  CONSTRAINT `fk_Pytania_Ankiety1`
    FOREIGN KEY (`Ankiety_idAnkiety`)
    REFERENCES `mydb`.`Ankiety` (`idAnkiety`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Odp_otwarta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Odp_otwarta` (
  `idOdp_otwarta` INT NOT NULL AUTO_INCREMENT,
  `Tresc` VARCHAR(45) NULL,
  `Pytania_idPytania` INT NOT NULL,
  PRIMARY KEY (`idOdp_otwarta`),
  INDEX `fk_Odp_otwarta_Pytania1_idx` (`Pytania_idPytania` ASC),
  CONSTRAINT `fk_Odp_otwarta_Pytania1`
    FOREIGN KEY (`Pytania_idPytania`)
    REFERENCES `mydb`.`Pytania` (`idPytania`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Odp_zamknieta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Odp_zamknieta` (
  `idOdp_zamknieta` INT NOT NULL AUTO_INCREMENT,
  `Tresc` VARCHAR(45) NULL,
  `Pytania_idPytania` INT NOT NULL,
  PRIMARY KEY (`idOdp_zamknieta`),
  INDEX `fk_Odp_zamknieta_Pytania1_idx` (`Pytania_idPytania` ASC),
  CONSTRAINT `fk_Odp_zamknieta_Pytania1`
    FOREIGN KEY (`Pytania_idPytania`)
    REFERENCES `mydb`.`Pytania` (`idPytania`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Wypelnione_ankiety`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Wypelnione_ankiety` (
  `idWypelnione_ankiety` INT NOT NULL AUTO_INCREMENT,
  `Ankietowany_idAnkietowany` INT NOT NULL,
  PRIMARY KEY (`idWypelnione_ankiety`),
  INDEX `fk_Wypelnione_ankiety_Ankietowany1_idx` (`Ankietowany_idAnkietowany` ASC),
  CONSTRAINT `fk_Wypelnione_ankiety_Ankietowany1`
    FOREIGN KEY (`Ankietowany_idAnkietowany`)
    REFERENCES `mydb`.`Ankietowany` (`idAnkietowany`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Odp_zamknieta_has_Ankietowany`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Odp_zamknieta_has_Ankietowany` (
  `Ankietowany_idAnkietowany` INT NOT NULL,
  `Odp_zamknieta_idOdp_zamknieta` INT NOT NULL,
  INDEX `fk_Odp_zamknieta_has_Ankietowany_Ankietowany1_idx` (`Ankietowany_idAnkietowany` ASC),
  INDEX `fk_Odp_zamknieta_has_Ankietowany_Odp_zamknieta1_idx` (`Odp_zamknieta_idOdp_zamknieta` ASC),
  CONSTRAINT `fk_Odp_zamknieta_has_Ankietowany_Ankietowany1`
    FOREIGN KEY (`Ankietowany_idAnkietowany`)
    REFERENCES `mydb`.`Ankietowany` (`idAnkietowany`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Odp_zamknieta_has_Ankietowany_Odp_zamknieta1`
    FOREIGN KEY (`Odp_zamknieta_idOdp_zamknieta`)
    REFERENCES `mydb`.`Odp_zamknieta` (`idOdp_zamknieta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
