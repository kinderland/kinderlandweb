/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package migracaokinderlandv2;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.mindrot.jbcrypt.BCrypt;

/**
 *
 * @author Rafael
 */
public class Coiote extends Base {

    public Driver driver;

    public Coiote() {
        this.driver = new Driver();
    }

    private ResultSet getTodos(String query) {
        try {
            PreparedStatement preparedStatement = driver.prepareStatement(this.propertiesFile.getProperty(query));
            return driver.executeQuery(preparedStatement);
        } catch (Exception ex) {
            log.errorPrint(ex);
        }
        return null;
    }

    private void insertPerson() {
        try {
            log.title("Inserindo pessoas");
            ResultSet pessoas = this.getTodos("select_todas_pessoas");
            while (pessoas.next()) {
                log.msgPrint("Migrando: " + pessoas.getString("nome"));
                PreparedStatement preparedStatement = driver.prepareStatement(this.propertiesFile.getProperty("insert_person"));
                preparedStatement.setInt(1, Integer.parseInt(pessoas.getString("sequencial")));
                preparedStatement.setString(2, pessoas.getString("nome"));
                preparedStatement.setDate(3, pessoas.getDate("data_de_cadastro"));
                preparedStatement.setString(4, pessoas.getString("sexo"));
                preparedStatement.setString(5, pessoas.getString("email"));
                driver.executeUpdate(preparedStatement);
            }
        } catch (SQLException ex) {
            Logger.getLogger(Coiote.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    private void insertPersonUser() {
        try {
            log.title("Inserindo usuarios");
            ResultSet pessoas = this.getTodos("select_todos_responsaveis");
            while (pessoas.next()) {
                log.msgPrint("Migrando: " + pessoas.getString("email").toLowerCase());
                PreparedStatement preparedStatement = driver.prepareStatement(this.propertiesFile.getProperty("insert_person_user"));
                preparedStatement.setInt(1, Integer.parseInt(pessoas.getString("sequencial")));
                preparedStatement.setString(2, pessoas.getString("cpf"));
                preparedStatement.setString(3, pessoas.getString("email").toLowerCase());
                preparedStatement.setString(4, this.getSenhaEncriptada(pessoas.getString("cpf")));
                preparedStatement.setString(5, pessoas.getString("ocupacao"));
                driver.executeUpdate(preparedStatement);
            }
        } catch (SQLException ex) {
            Logger.getLogger(Coiote.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    private void insertPersonUserType() {
        try {
            log.title("Inserindo PersonUserType");
            PreparedStatement preparedStatement = driver.prepareStatement(this.propertiesFile.getProperty("insert_user_type"));
            driver.executeUpdate(preparedStatement);
        } catch (Error ex) {
            Logger.getLogger(Coiote.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    private String getSenhaEncriptada(String senha) {
        return BCrypt.hashpw(senha, BCrypt.gensalt(11));
    }

    public void limpaBD() {
        try {
            log.title("Limpando BD");
            PreparedStatement preparedStatement = driver.prepareStatement(this.propertiesFile.getProperty("limpa_bd"));
            driver.executeUpdate(preparedStatement);
        } catch (Error ex) {
            Logger.getLogger(Coiote.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public void insertTelephone() {
        int i = 1;
        try {
            log.title("Inserindo telefones");
            PreparedStatement preparedStatement = driver.prepareStatement(this.propertiesFile.getProperty("insert_telephone"));
            driver.executeUpdate(preparedStatement);
        } catch (Error ex) {
            Logger.getLogger(Coiote.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public void insertAdress() {
        int i = 1;
        try {
            log.title("Inserindo endereços");
            ResultSet enderecos = this.getTodos("select_todos_enderecos");
            while (enderecos.next()) {
                log.msgPrint(enderecos.getString("bairro"));
                PreparedStatement preparedStatement = driver.prepareStatement(this.propertiesFile.getProperty("insert_adress"));
                preparedStatement.setInt(1, i);
                preparedStatement.setString(2, enderecos.getString("rua"));
                preparedStatement.setString(3, enderecos.getString("numero"));
                preparedStatement.setString(4, enderecos.getString("complemento"));
                preparedStatement.setString(5, enderecos.getString("cidade"));
                preparedStatement.setString(6, enderecos.getString("cep"));
                preparedStatement.setString(7, enderecos.getString("estado"));
                preparedStatement.setString(8, enderecos.getString("bairro"));
                driver.executeUpdate(preparedStatement);
                PreparedStatement preparedStatement2 = driver.prepareStatement("update person set address_id = ? where person_id = ?;");
                preparedStatement2.setInt(1, i++);
                preparedStatement2.setInt(2, enderecos.getInt("person_id"));
                driver.executeUpdate(preparedStatement2);
            }
        } catch (SQLException ex) {
            Logger.getLogger(Coiote.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public void migrar() {
        driver.beginTransaction();
        this.limpaBD();
        driver.commitTransaction();
        driver.beginTransaction();
        this.insertPerson();
        driver.commitTransaction();
        driver.beginTransaction();
        this.insertPersonUser();
        driver.commitTransaction();
        driver.beginTransaction();
        this.insertTelephone();
        driver.commitTransaction();
        driver.beginTransaction();
        this.insertAdress();
        driver.commitTransaction();
        driver.beginTransaction();
        this.insertPersonUserType();
        driver.commitTransaction();
    }

}
