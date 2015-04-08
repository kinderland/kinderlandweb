/*
 * Automatic Create Materialized Views
 * Authors: rpoliveira@inf.puc-rio.br, sergio@inf.puc-rio.br  *
 */
package migracaokinderlandv2;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class Driver extends Base {

    public Driver() {
        super();
        connect();
    }

    protected static Connection connection = null;
    private Statement statement;

    private void connect() {
        try {
            if (connection == null) {
                connection = DriverManager.getConnection(this.propertiesFile.getProperty("urlPostgres"), this.propertiesFile.getProperty("userPostgres"), this.propertiesFile.getProperty("pwdPostgres"));
                log.msgPrint("Aplicação versão: " + this.propertiesFile.getProperty("versao"));
                log.msgPrint("Conectado ao bd " + this.propertiesFile.getProperty("urlPostgres"));
            }
        } catch (SQLException e) {
            log.errorPrint(e);
        }
    }

    public void closeConnection() throws SQLException {
        Driver.connection.close();
    }

    public PreparedStatement prepareStatement(String query) {
        try {
            return Driver.connection.prepareStatement(query);
        } catch (SQLException e) {
            log.errorPrint(e);
            return null;
        }
    }

    public void createStatement() {
        try {
            this.statement = Driver.connection.createStatement();
        } catch (SQLException e) {
            log.errorPrint(e);
        }
    }

    public ResultSet executeQuery(String query) {
        try {
            return statement.executeQuery(query);
        } catch (SQLException e) {
            log.errorPrint(e);
            return null;
        }
    }

    public void closeStatement() {
        try {
            this.statement.close();
        } catch (SQLException e) {
            log.errorPrint(e);
        }
    }

    public void executeUpdate(PreparedStatement prepared) {
        try {
            prepared.executeUpdate();
        } catch (SQLException e) {
            log.errorPrint(e);
        }
    }

    public ResultSet executeQuery(PreparedStatement prepared) {
        try {
            return prepared.executeQuery();
        } catch (SQLException e) {
            log.errorPrint(e);
            return null;
        }
    }

    void beginTransaction() {
        PreparedStatement preparedStatement = this.prepareStatement("BEGIN;");
        this.executeUpdate(preparedStatement);
    }

    void commitTransaction() {
        PreparedStatement preparedStatement = this.prepareStatement("COMMIT;");
        this.executeUpdate(preparedStatement);
    }

}
